<?php
    
    include_once 'model/Member.php';
    include_once 'model/MemberManager.php';

    
    $label_err_login1 = "";
    $label_err_login2 = "";
    $label_err_password1 = "";
    $label_err_password2 = "";
    $label_err_mail = "";
    
    
    if (isset($_POST['reg']))
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $password_check = $_POST['password_check'];
        $mail = $_POST['mail'];
        
        $err_login1 = false;
        $err_login2 = false;
        $err_password1 = false;
        $err_password2 = false;
        $err_mail = false;

        
        if (strlen($login) > 20 || empty($login))
        {
            $err_login1 = true;
            $label_err_login1 = "Invalid login ! (max 20 chars)<br/>";
        }
        
        $manager = new MemberManager($db);
        
        if ($manager->getId($login)->getLogin()!="")
        {
            $err_login2 = true;
            $label_err_login2 = "Login already taken !<br/>";
        }
        
        
        if (($err_login1) || ($err_login2))
        {
            $login = "";
        }
        
        
        if (strlen($password) < 6 || strlen($password) > 40 )
        {
            $err_password1 = true;
            $label_err_password1 = "Password length between 6 and 40<br/>";
            
        }
        
        if ($password != $password_check)
        {
            $err_password2 = true;
            $label_err_password2 = "Passwords are different<br/>";
        }
        
        if (empty($mail))
        {
            $err_mail = true;
            
        }
        
        if ($err_mail)
        {
            $label_err_mail = "Invalid<br/>";
            $mail = "";
        }
        
        if ((!$err_login1) && (!$err_login2) && (!$err_password2) && (!$err_password1) && (!$err_mail))
        {
            
            $password = sha1($password);
            
            $data = array('login' => $login,
                          'password' => $password,
                          'mail' => $mail);
            
            $user = new Member($data);
                    
            $manager->add($user);
            header('Location: ../index.php');
            
        }
        else
        {
            include_once 'view/vRegister.php';
        }
        
        
        
    }
    
    else
    {
        include_once 'view/vRegister.php';
    }
    
    