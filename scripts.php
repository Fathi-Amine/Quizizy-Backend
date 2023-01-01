<?php
include_once("classes/questionClass.php");
if ($_GET['data'] == 'questions') {
    echo json_encode(getquests());
  } elseif ($_GET['data'] == 'answers') {
    echo json_encode(array('data' => correctAnswers()));
  }


function getquests(){
    $test = Questions::getquestions();
    return $test;
}

function correctAnswers(){
    $corrects = Questions::getCorrectAnswers();
    return $corrects;
}
// echo json_encode(getquests());
// echo json_encode(getquests());
// echo json_encode(correctAnswers());
?>