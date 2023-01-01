<?php
include_once("scripts.php");
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
    </style>
</head>
<body>
    <button type="button" class="btn">Get questions</button>
    <button type="button" class="next">Next Please</button>
    <div class="newContent"></div>
    <script>
        let index = 0;
        var response
        const div = document.querySelector('.newContent');
        const btn = document.querySelector('.btn')
        const nextBtn = document.querySelector('.next');
        function peaceLakhdmat(get){
            const xhr = new XMLHttpRequest();
            
            xhr.open("GET","scripts.php?data=questions",false);
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
            showQuestion(shuffledquests[0])
            index=1;
            nextBtn.addEventListener("click",()=>{
            nextBtn.style.display = "none"

                setTimeout(() => {
                    showQuestion(shuffledquests[index])
                }, 2000);
                index++;
            })
        }

        function showQuestion(quest){
            nextBtn.style.display = "block";
            console.log(quest)
        //    div.innerHTML=quest["question"]
        }
        btn.addEventListener("click", ()=>{
            peaceLakhdmat(getQuestions)
        })

        
       
    </script>
</body>
</html>