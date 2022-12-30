<?php
include "database.php";

class Questions extends DatabaseConnection{
    // protected function connect(){
    //     return parent::connect();
    // }
    public static function getquestions(){
        $sql = "SELECT ques.question,ques.description,
         MIN(CASE WHEN ans.id = (ques.id*4)-3 THEN ans.answer END) AS answer1, 
         MAX(CASE WHEN ans.id = (ques.id*4)-2 THEN ans.answer END) AS answer2, 
         MIN(CASE WHEN ans.id = (ques.id*4)-1 THEN ans.answer END) AS answer3, 
         MAX(CASE WHEN ans.id = (ques.id*4) THEN ans.answer END) AS answer4 FROM questions ques JOIN answers ans GROUP by ques.id ORDER by ques.id";
        $db = new DatabaseConnection();
        $pdo = $db->connect();
        $stmt = $pdo->query($sql);
        $res = $stmt->fetchAll();
        return $res;
    }
}

?>