<?php
include "database.php";

class Questions extends DatabaseConnection{
    // protected function connect(){
    //     return parent::connect();
    // }
    public static function getquestions(){
        $sql = "SELECT ques.id,ques.question,ques.description, 
        MIN(CASE WHEN ans.id = (ques.id*4)-3 THEN ans.answer END) AS answer1,
        MIN(CASE WHEN ans.id = (ques.id*4)-3 THEN ans.id END) AS id_1, 
        MAX(CASE WHEN ans.id = (ques.id*4)-2 THEN ans.answer END) AS answer2,
        MIN(CASE WHEN ans.id = (ques.id*4)-2 THEN ans.id END) AS id_2, 
        MIN(CASE WHEN ans.id = (ques.id*4)-1 THEN ans.answer END) AS answer3,
        MIN(CASE WHEN ans.id = (ques.id*4)-1 THEN ans.id END) AS id_3, 
        MAX(CASE WHEN ans.id = (ques.id*4) THEN ans.answer END) AS answer4,
        MIN(CASE WHEN ans.id = (ques.id*4) THEN ans.id END) AS id_4 
        FROM questions ques JOIN answers ans GROUP by ques.id ORDER by ques.id;";
        $db = new DatabaseConnection();
        $pdo = $db->connect();
        $stmt = $pdo->query($sql);
        $res = $stmt->fetchAll();
        return $res;
    }

    public static function getCorrectAnswers(){
        $sql = "SELECT answer,quest_id From answers Where iscorrect = 1";
        $db = new DatabaseConnection();
        $pdo = $db->connect();
        $stmt = $pdo->query($sql);
        $res = $stmt->fetchAll();
        return $res;
    }

    public static function verifyAnswer($id){
        $sql = "SELECT isCorrect FROM `answers` where id='$id'";
        $db = new DatabaseConnection();
        $pdo = $db->connect();
        $stmt = $pdo->query($sql);
        $res = $stmt->fetchAll();
        return $res[0];
    }

}

?>