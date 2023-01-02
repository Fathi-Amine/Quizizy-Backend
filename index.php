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
    </style>
</head>
<body>
    <button type="button" class="btn">Get questions</button>
    <button type="button" class="next">Next Please</button>
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
        let userChoice = {};
        let userAnswers = [];
        let index = 0;
        var response
        const div = document.querySelector('.newContent');
        const btn = document.querySelector('.btn')
        const nextBtn = document.querySelector('.next');
        const questionHeader = document.querySelector(".question");
        const answersContainer = document.querySelector(".answers-container");
        function peaceLakhdmat(get){
            const xhr = new XMLHttpRequest();
            console.log(xhr);
            xhr.open("GET","scripts.php?data=questions",true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    let questions = JSON.parse(this.responseText);
                    let values = Object.values(questions)
                    get(values);
                    // displayQuestions(questions);
                    // response = questions;
                }
            };
            xhr.send();
        }
        
        
        
        
        function getQuestions(shuffledquests){
            btn.style.display="none";
            showQuestion(shuffledquests, shuffledquests[0])
            index=1;
            nextBtn.addEventListener("click",()=>{
            nextBtn.style.display = "none"
            // console.log(shuffledquests.length)
            document.querySelectorAll('.answerBtn').forEach((btn)=>{
                if(btn.classList.contains('selected')){
                    let ansId = btn.dataset.answerid;
                    // console.log(ansId);
                    const xhrVerify = new XMLHttpRequest();
                    xhrVerify.onreadystatechange = function (){
                        if (this.readyState == 4 && this.status == 200) {
                            let response = JSON.parse(this.responseText);
                            console.log(response["isCorrect"]);
                            if(response["isCorrect"]== '1'){
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
            // const xhrVerify = new XMLHttpRequest();
            // xhrVerify.onreadystatechange = function (){
            //     if (this.readyState == 4 && this.status == 200) {
            //         console.log(this.responseText);
            //     }
            // }
            // xhrVerify.open('POST','scripts.php',true);
            // xhrVerify.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            // xhrVerify.send('data=')
            
                setTimeout(() => {
                    showQuestion(shuffledquests,shuffledquests[index])
                }, 2000);
                index++;
            })
        }

        function showQuestion(shuffledquests, quest){
            if(index < shuffledquests.length){
                nextBtn.style.display = "block";
                questionHeader.innerText = quest.question;
                answersContainer.innerHTML = "";
                userChoice = {id:quest[`id`], answer:"No answer is selected"};
                for(i=1; i<=4; i++){
                    let answer = `answer${i}`;
                    let answerId = `id_${i}`;
                    answersContainer.innerHTML += `
                    <button type="button" data-questId="${quest['id']}" data-answerId="${quest[answerId]}" class="answerBtn" onclick='highlightSelected(this,this.dataset.questid)'>${quest[answer]}</button>
                    `
                }
                // console.log(quest["id"]);
                // console.log(quest)
            }else{
                console.log("finished");
            }
            
            // console.log(userChoice)
        //    div.innerHTML=quest["question"]
        }

    function highlightSelected(element, id){
        userChoice = {};
        const Btns = document.querySelectorAll('.answerBtn');
        for(let i = 0; i< Btns.length;i++){
            Btns[i].classList.remove('selected');
        }
        element.classList.add('selected');
        // selected=element;
        userChoice.id = id;
        userChoice.answer = element.innerText;
        // userChoice.isItCorrect = isCorrect;
        // console.log(userChoice)
    }

        btn.addEventListener("click", ()=>{
            peaceLakhdmat(getQuestions)
        })

        
       
    </script>
</body>
</html>