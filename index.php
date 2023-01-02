<?php
// include_once("scripts.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .next{
            display: none;
        }

        .selected{
            background-color: pink;
        }

        .correct{
            background-color: green;
        }
        .false{
            background-color: red;
        }

        .show{
            display:none;
        }
    </style>
</head>
<body>
    <button type="button" class="btn">Get questions</button>
    <button type="button" class="next">Next Please</button>
    <button type="button" class="show">show Results</button>
    <div class="newContent"></div>
    <div class="quizz-container">
        <h2 class="question"></h2>
        <div class="answers-container">
        </div>

        <div class="next-container">
            <button class="next btn">next</button>
        </div>
    </div>
    <script>
        let questions = [];
        let userChoice = {};
        let userAnswers = [];
        let index = 0;
        var response
        const div = document.querySelector('.newContent');
        const btn = document.querySelector('.btn')
        const nextBtn = document.querySelector('.next');
        const questionHeader = document.querySelector(".question");
        const answersContainer = document.querySelector(".answers-container");
        const resultBtn = document.querySelector('.show')
        function peaceLakhdmat(get){
            const xhr = new XMLHttpRequest();
            console.log(xhr);
            xhr.open("GET","scripts.php?data=questions",true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    let questions = JSON.parse(this.responseText);
                    let values = Object.values(questions)
                    // get(values);
                    get(values)
                    // displayQuestions(questions);
                    // response = questions;
                }
            };
            xhr.send();
        }
        
        
        function getQsArray(questions){
            console.log(questions);
        }
        
        function getQuestions(shuffledquests){
            btn.style.display="none";
            showQuestion(shuffledquests, shuffledquests[0])
            index=1;
            nextBtn.addEventListener("click",()=>{
                nextBtn.style.display = "none";
                showCorrectAnswer();
                setTimeout(() => {
                    showQuestion(shuffledquests,shuffledquests[index])
                }, 2000);   
            })
        }

        function showQuestion(shuffledquests, quest){
            if(index < shuffledquests.length){
                questionHeader.innerText = quest.question;
                answersContainer.innerHTML = "";
                userChoice = {id:quest[`id`], answer:"No answer is selected",answerId:'0'};
                for(i=1; i<=4; i++){
                    let answer = `answer${i}`;
                    let answerId = `id_${i}`;
                    answersContainer.innerHTML += `
                    <button type="button" data-questId="${quest['id']}" data-answerId="${quest[answerId]}" class="answerBtn" onclick='highlightSelected(this,this.dataset.questid,this.dataset.answerid)'>${quest[answer]}</button>
                    `
                }
                nextBtn.style.display = "block";
                index++;
                console.log(questions);
            }else{
                resultBtn.style.display = "block";
                questions = [...shuffledquests];
                console.log(questions);
                // console.log(shuffledquests)
                console.log("finished");
            }
            
            // console.log(userChoice)
        //    div.innerHTML=quest["question"]
        }

    function highlightSelected(element, questid, answerid){
        userChoice = {};
        const Btns = document.querySelectorAll('.answerBtn');
        for(let i = 0; i< Btns.length;i++){
            Btns[i].classList.remove('selected');
        }
        element.classList.add('selected');
        // selected=element;
        userChoice.id = questid;
        userChoice.answer = element.innerText;
        userChoice.answerId = answerid;
        // userChoice.isItCorrect = isCorrect;
        console.log(userChoice)
    }

    function showCorrectAnswer(){
        document.querySelectorAll('.answerBtn').forEach((btn)=>{
            if(btn.classList.contains('selected')){
                let ansId = btn.dataset.answerid;
                // console.log(ansId);
                const xhrVerify = new XMLHttpRequest();
                xhrVerify.onreadystatechange = function (){
                    if (this.readyState == 4 && this.status == 200) {
                        let response = JSON.parse(this.responseText);
                        console.log(response["isCorrect"]);
                        if(response["isCorrect"]){
                            btn.classList.add('correct');
                        }else{
                            btn.classList.add('false');
                        }
                    }
                }
                xhrVerify.open('POST','scripts.php',true);
                xhrVerify.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhrVerify.send(`data=${ansId}`);
            }
        })

        userAnswers.push(userChoice)
        console.log(userAnswers)
    }

    function showResults(correctAnswers){
        userAnswers.forEach((userAnswer)=>{
            const questionBlock = document.createElement('div');
            questionBlock.classList.add('result-card');
            const question = document.createElement('h3');
            const answersBlock = document.createElement('div');
            answersBlock.classList.add('answersBlock');
            const matchingQuestion = questions.find((ques)=> ques["id"] == userAnswer.id);
            console.log(matchingQuestion);
        })
    }

        btn.addEventListener("click", ()=>{
            peaceLakhdmat(getQuestions)
        })
        resultBtn.addEventListener("click", ()=>{
            const xhrResult = new XMLHttpRequest();
            xhrResult.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    showResults(JSON.parse(this.responseText))
                    console.log(this.responseText)
                }
            }
            xhrResult.open('GET',"scripts.php?data=answers",true);
            xhrResult.send();
        })

        
       
    </script>
</body>
</html>