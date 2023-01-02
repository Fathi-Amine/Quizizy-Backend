<?php
include_once("classes/questionClass.php");
if (isset($_GET['data']) && $_GET['data'] == 'questions') {
    echo json_encode(getquests());
  } elseif (isset($_GET['data']) && $_GET['data'] == 'answers') {
    echo json_encode(array('data' => correctAnswers()));
  }
if(isset($_POST['data'])){
  echo json_encode(iscorrect($_POST['data']));
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
function iscorrect($id){
  $status = Questions::verifyAnswer($id);
    return $status;
}
?>