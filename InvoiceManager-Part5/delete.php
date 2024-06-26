<?php
    require "data.php";
    require "functions.php";

    if($_SERVER['REQUEST_METHOD']=== 'POST'){
        deleteInvoice($_POST['number']);
    }

    header("Location: index.php");
    exit;
