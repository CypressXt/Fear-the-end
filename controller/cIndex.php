<?php

include_once 'model/Member.php';
include_once 'model/MemberManager.php';




$label_err = "";
if (isset($_POST['auth'])) {
    $login = $_POST['login'];
    $password = sha1($_POST['password']);


    $manager = new MemberManager($db);
    $member = $manager->getId($login);

    if ($password == $member->getPassword()) {
        $_SESSION['loggedUserObject'] = serialize($member);
        //$_SESSION['username'] = htmlspecialchars($member->getLogin());
        $_SESSION['logged'] = true;
        setcookie("loggedCookies", "loggedOnce", time() + 86400);
        header('Location:'. $_SERVER['HTTP_REFERER']);
    } else {
        $label_err = "Incorrect username or password";
        include_once 'view/vIndex.php';
        include_once 'model/popup.php';
    }
} else {
    include_once 'view/vIndex.php';
}