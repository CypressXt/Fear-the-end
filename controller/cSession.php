<?php
    if ($_SESSION)
    {
        include_once 'view/vWelcome.php';
    }
    else
    {
        include_once 'view/vHome.php';
    }