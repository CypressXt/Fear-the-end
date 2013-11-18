<?php

session_start();

include_once '/secrets/sqlConnect.php';

$l = isset($_GET['l']) ? $_GET['l'] : false;

// Get to controller

switch ($l) {
    case false:
        include_once('controller/cIndex.php');
        break;
    case "index":
        include_once('controller/cIndex.php');
        break;
    case "register":
        include_once('controller/cRegister.php');
        break;
    case "IT":
        include_once('./controller/cIT.php');
        break;
    case "ownIT":
        include_once('./controller/cIT.php');
        break;
    case "projectByTag":
        include_once('./controller/cIT.php');
        break;
    case "project":
        include_once('./controller/cProject.php');
        break;
    case "newProject":
        include_once('./controller/cProject.php');
        break;
}