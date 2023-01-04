<?php
include_once("classes/questionClass.php");
if (isset($_GET['data']) && $_GET['data'] == 'questions') {
    echo json_encode(getquests());
  } elseif (isset($_GET['data']) && $_GET['data'] == 'answers') {
    echo json_encode(correctAnswers());
  }
if(isset($_POST['data'])){
  echo json_encode(iscorrect($_POST['data']));
}

if(isset($_POST['userAnswers'])){
  echo json_encode(validateAnswers($_POST['userAnswers']));
}


function getquests(){
    $test = Questions::getquestions();
    shuffle($test);
    return $test;
}

function correctAnswers(){
    $corrects = Questions::getCorrectAnswers();

    return $corrects;
}
// echo json_encode(getquests());
// echo json_encode(getquests());
// echo json_encode(correctAnswers());
function iscorrect($id){
  $status = Questions::verifyAnswer($id);
    return $status;
}

function validateAnswers($arr){
  $answers = json_decode($arr);
  $score = 0;
  $arra=[];
  $arra1=[];
  foreach ($answers as $answer) {
    $isItCorrect = Questions::verifyAnswer($answer->answerId);
    if($isItCorrect["isCorrect"]){
      $arra[]= $answer->answerId;
      $score += 10;
    }else{
      $arra1[]= $answer->answerId;
      $score += 0;
    }
  }
  
  $str=implode(',', $arra);
  $str1=implode(',', $arra1);
  $result = Questions::getWrongAnswers($str, $str1);
  $correctAnswers = Questions::getCorrectAnswers();
  $response = array('score'=>$score, 'wrongAnswers'=>$result, "correctAnswers"=>$correctAnswers);
  return $response;
}

?>