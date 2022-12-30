<?php
include_once("classes/questionClass.php");
$lklkerl;
if(isset($_GET["questions"]))  {
    $lklkerl=getquests();
}

if(){
    
}

function getquests(){
    $test = Questions::getquestions();
    return $test;
}

echo json_encode(getquests());
?>