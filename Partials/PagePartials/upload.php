<?php
    //var_dump($_FILES);
    var_dump($_POST);
    $Name = $_FILES['fileupload']['name'];
    $Size = $_FILES['fileupload']['size'];
    $Temp = $_FILES['fileupload']['tmp_name'];
    $Type = $_FILES['fileupload']['type'];

    /*foreach($_FILES as $arrName){
        echo json_encode($arrName, JSON_UNESCAPED_UNICODE)."<br>";
    }*/
?>