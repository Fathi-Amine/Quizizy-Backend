<?php
include_once("classes/questionClass.php");

if(isset($_GET["answers"])){
    correctAnswers();
}


function correctAnswers(){
    $corrects = Questions::getCorrectAnswers();
    return $corrects;
}
// echo json_encode($agent);
// echo json_encode(getquests());
echo json_encode(correctAnswers());
?>