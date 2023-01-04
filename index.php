<?php
// include_once("scripts.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/style.css">
    <title>Document</title>
    <style>
        /* .next{
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
        } */
    </style>
</head>
<body>
<div class="wrapper">
        <div id="progress">
            <div id="progress-bar"></div>
            <ul id="progress-num">
              <li class="step active">1</li>
              <li class="step">2</li>
              <li class="step">3</li>
            </ul>
        </div>
        <div class="blocks">
            <div class="input-block">
                <input type="text" class="input" placeholder="Enter Your name">
            </div>

            <div class="info-block">
                <h1 class="rules">
                    Rules
                </h1>
                <ul id="rules-list">
                    <li><span class="rule-number">1.</span>You have 30 seconds to answer each question</li>
                    <li><span class="rule-number">2.</span>Each Question has a description for the right answer</li>
                    <li><span class="rule-number">3.</span>The Quiz Contains 10 questions</li>
                    <li><span class="rule-number">4.</span>Good Luck!</li>
                </ul>
            </div>
            <div class="start-block">
                <button class="start btn">start</button>
            </div>
            <div class="prog-btns">
                <button id="progress-prev" class="btn" disabled>Prev</button>
                <button id="progress-next" class="btn">Next</button>
            </div>
        </div>
        <div class="quiz-wrapper">
            <h1 class="quiz-title">Aws Quiz</h1>
            <div class="progAndTimer">
                <span class="time"></span>
                <div class="progContainer">
                    <div class="progBar"></div>
                </div>
            </div>
            <div class="quizz-container">
                <h2 class="question"></h2>
                <div class="answers-container">
                </div>
                
                <div class="next-container">
                    <button class="next btn">next</button>
                </div>
            </div>
        </div>
        <div class="resultBoard">
            <h1 class="scoreBanner"></h1>
        </div>
        <button type="button" class="btn result-btn">Result</button>
        <button type="button" class="btn restart">Restart</button>
    </div>
    <!-- <button type="button" class="btn start">Get questions</button>
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

        <div class="resultBoard"></div>
    </div> -->
    <script src="assets/script.js"></script>
</body>
</html>