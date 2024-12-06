<?php
   require_once __DIR__.'/vendor/autoload.php';
   ini_set('display_errors', 1);
   error_reporting(E_ALL);
   // session_start();
   //$currentUser = $_SESSION["userId"];
   require_once(__DIR__ . "/classes/Product.php");
   require_once(__DIR__ . '/classes/Db.php');
   

    //opstart file
    session_start();
