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
        FROM questions ques JOIN answers ans GROUP by ques.id ORDER by ques.id LIMIT 4;";
        $db = new DatabaseConnection();
        $pdo = $db->connect();
        $stmt = $pdo->query($sql);
        $res = $stmt->fetchAll();
        return $res;
    }

    public static function getCorrectAnswers(){
        $sql = "SELECT id,answer,quest_id From answers Where iscorrect = 1";
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

    public static function getWrongAnswers($str, $str1){
        $sql = "SELECT *,ans.id AS wrong_id FROM questions ques 
        INNER JOIN answers ans ON ques.id = ans.quest_id 
        WHERE ans.id IN ($str1) AND ans.id NOT IN ($str);";
        $db = new DatabaseConnection();
        $pdo = $db->connect();
        $stmt = $pdo->query($sql);
        $res = $stmt->fetchAll();
        return $res;

    }

}

// // Step 1: Create the loader element
// var loader = document.createElement("div");

// // Step 2: Style the loader
// loader.style.width = "64px";
// loader.style.height = "64px";
// loader.style.border = "2px solid #ccc";
// loader.style.borderTop = "2px solid #333";
// loader.style.borderRadius = "100%";
// loader.style.margin = "auto";
// loader.style.animation = "spin 0.5s linear infinite";

// // Add a keyframe animation for the spin
// var css = `
// @keyframes spin {
//   0% { transform: rotate(0deg); }
//   100% { transform: rotate(360deg); }
// }
// `;

// // Add the animation to a style sheet
// var style = document.createElement("style");
// style.innerHTML = css;
// document.head.appendChild(style);

// // Step 3: Make the AJAX request
// var xhr = new XMLHttpRequest();
// xhr.open("GET", "https://example.com/data.json");

// // Step 4: Display the loader
// document.body.appendChild(loader);

// // Step 5: Hide the loader when the request is complete
// xhr.onload = function() {
//   if (this.status >= 200 && this.status < 300) {
//     // Request succeeded
//     loader.style.display = "none";
//     // Do something with the response data
//   } else {
//     // Request failed
//     loader.style.display = "none";
//     // Do something with the error
//   }
// };

// xhr.send();


?>