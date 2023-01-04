const quizWrapper = document.querySelector('.quiz-wrapper');
const stepperBlock = document.querySelector('.blocks');
const progressBar = document.getElementById("progress-bar");
const progressNext = document.getElementById("progress-next");
const progressPrev = document.getElementById("progress-prev");
const steps = document.querySelectorAll(".step");
const infoBlock = document.querySelector(".info-block");
const inputBlock = document.querySelector(".input-block");
const startBlock = document.querySelector(".start-block");
const startBtn = document.querySelector(".start");
const div = document.querySelector('.newContent');
const btn = document.querySelector('.start')
const nextBtn = document.querySelector('.next');
const questionHeader = document.querySelector(".question");
const answersContainer = document.querySelector(".answers-container");
const resultBtn = document.querySelector('.result-btn');
const resultBoard = document.querySelector('.resultBoard');
const time = document.querySelector(".time");
const progBar = document.querySelector(".progBar");
const score = document.querySelector(".scoreBanner");
const restartBtn = document.querySelector(".restart");
let questions = [];
let userChoice = {};
let userAnswers = [];
let index = 0;
let active = 1;
let timeOut;
let timeInSeconds = 0;
let interval = 0;

function countDown(){
  if(timeInSeconds === 30){
      clearInterval(interval);
      nextBtn.disabled = false;
      nextBtn.click();
  }else{
      time.style.display = "inline-block"
      timeInSeconds++;
      time.innerText = timeInSeconds;
  }
}
progressNext.addEventListener("click", () => {
    console.log("eeeee");
    active++;
    if (active > steps.length) {
        active = steps.length;
    }
    updateProgress();
});

  progressPrev.addEventListener("click", () => {
    active--;
    if (active < 1) {
      active = 1;
    }
    updateProgress();
  });

  const updateProgress = () => {
    // toggle active class on list items
    steps.forEach((step, i) => {
      if (i < active) {
        step.classList.add("active");
      } 
      else {
        step.classList.remove("active");
      }
    });
    // set progress bar width  
    progressBar.style.width = 
      ((active - 1) / (steps.length - 1)) * 100 + "%";
    // enable disable prev and next buttons
    if (active === 1) {
      progressNext.disabled = false;
      progressPrev.disabled = true;
      infoBlock.style.display="none";
      inputBlock.style.display = "block";
    }else if(active === steps.length - 1) {
      progressPrev.disabled = false;
      startBlock.style.display = "none";
      infoBlock.style.display="block";
      inputBlock.style.display = "none";

    }
    else if (active === steps.length) {
      progressNext.disabled = true;
      startBlock.style.display = "block";
      infoBlock.style.display="none";
      inputBlock.style.display = "none";
    } else {
      progressPrev.disabled = false;
      progressNext.disabled = false;
      startBlock.style.display = "none";
    }
  };


  ///////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////



var response

function dataAgent(get){
    const xhr = new XMLHttpRequest();
    xhr.open("GET","scripts.php?data=questions",true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            let questions = JSON.parse(this.responseText);
            let values = Object.values(questions)
            get(values)
        }
    };
    xhr.send();
}




function getQuestions(shuffledquests){
    btn.style.display="none";
    showQuestion(shuffledquests, shuffledquests[0])
    index=1;
    nextBtn.addEventListener("click",()=>{
        nextBtn.style.display = "none";
        nextBtn.disabled = true;
        showCorrectAnswer();
        setTimeout(() => {
            showQuestion(shuffledquests,shuffledquests[index])
        }, 2000);   
    })
}

function showQuestion(shuffledquests, quest){
    if(index < shuffledquests.length){
        timeInSeconds = 0
        clearInterval(interval);
        interval = setInterval(countDown, 1000);
        questionHeader.innerText = quest.question;
        answersContainer.innerHTML = "";
        userChoice = {id:quest[`id`], answer:"No answer is selected",answerId:'41'};
        for(i=1; i<=4; i++){
            let answer = `answer${i}`;
            let answerId = `id_${i}`;
            answersContainer.innerHTML += `
            <button type="button" data-questId="${quest['id']}" data-answerId="${quest[answerId]}" class="answerBtn" onclick='highlightSelected(this,this.dataset.questid,this.dataset.answerid)'>${quest[answer]}</button>
            `
        }
        nextBtn.style.display = "block"
        nextBtn.disabled = true;
        index++;
        showProg();
    }else{
        resultBtn.style.display = "block";
        questions = [...shuffledquests];
    }
}

function highlightSelected(element, questid, answerid){
userChoice = {};
nextBtn.disabled = false;
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
time.innerText = "";
clearInterval(interval);
document.querySelectorAll('.answerBtn').forEach((btn)=>{
    if(btn.classList.contains('selected')){
        let ansId = btn.dataset.answerid;
        console.log(ansId);
        const xhrVerify = new XMLHttpRequest();
        xhrVerify.onreadystatechange = function (){
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                console.log(response["isCorrect"]);
                if(response["isCorrect"]){
                    btn.classList.remove('selected');
                    btn.classList.add('correct');
                }else{
                    btn.classList.remove('selected');
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

function treatResults(response){
  if(response['score'] == (questions.length * 10)){
    score.innerText = `great job you got Everything right 100`;
  }else{
    response.wrongAnswers.forEach((wrongAnswer)=>{
      const questionBlock = document.createElement('div');
      questionBlock.classList.add('result-card');
      const question = document.createElement('h3');
      const answersBlock = document.createElement('div');
      answersBlock.classList.add('answersBlock');
      const descDiv = document.createElement('p');
      descDiv.classList.add('desc');
      const matchingQuestion = questions.find((ques)=> ques["id"] == wrongAnswer["quest_id"]);
      descDiv.innerHTML=`<span class="highlight">Desciption:</span> ${matchingQuestion["description"]}`
      const questionCorrectAnswer = response.correctAnswers.find((ans)=> wrongAnswer["quest_id"] == ans["quest_id"]);
      question.innerText = wrongAnswer["question"];
      console.log(matchingQuestion)
      console.log(questions);
      console.log(questionCorrectAnswer)
      for(i=1; i<=4; i++){
        let answer = `answer${i}`;
        let answerId = `id_${i}`;
        const choiceBtn = document.createElement("p");
        choiceBtn.innerText = matchingQuestion[answer];
        if(matchingQuestion[answerId] == wrongAnswer["wrong_id"]){
            choiceBtn.classList.add('false');
        }else if(matchingQuestion[answerId] == questionCorrectAnswer["id"]){
            choiceBtn.classList.add('correct');
        }
        answersBlock.appendChild(choiceBtn)
      }
      questionBlock.appendChild(question);
      resultBoard.appendChild(questionBlock);
      questionBlock.appendChild(answersBlock)
      questionBlock.appendChild(descDiv);
      score.innerText = response["score"];
  })
  }

}

function showProg(){
  progBar.style.display = "block";
  progBar.style.width = `${(200/10)*index/2}%`;
}

function showResults(){

const xhrResult = new XMLHttpRequest();

xhrResult.open('POST', 'scripts.php');

xhrResult.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

xhrResult.addEventListener('load', () => {
const response = JSON.parse(xhrResult.responseText);
treatResults(response);
})
xhrResult.send(`userAnswers=${encodeURIComponent(JSON.stringify(userAnswers))}`);
}

btn.addEventListener("click", ()=>{
  quizWrapper.style.display = "block";
  stepperBlock.style.display = "none"
  dataAgent(getQuestions);
})
resultBtn.addEventListener("click", ()=>{
    showResults();
    resultBtn.style.display = "none";
    restartBtn.style.display = "block"
})

restartBtn.addEventListener("click",()=>{
  window.location.reload();
})