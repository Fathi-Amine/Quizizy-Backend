<?php
include_once("scripts.php")
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <button type="button" class="btn">Get questions</button>
    <script>
        document.querySelector('.btn').addEventListener("click",function(){
            console.log("eeee")
            const xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function (){
                if(this.readyState == 4 && this.status== 200){
                    console.log(this.responseText);
                }
            }
            
            xhr.open("GET","scripts.php?name=questions",true);
            xhr.send();
        })
    </script>
</body>
</html>