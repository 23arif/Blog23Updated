<?php

try{
    $db= new PDO ("mysql:host=localhost;dbname=blog","root","");
}catch(PDOException $mesaj){
    echo $mesaj->getmessage();
}


?>