<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="../style/style.css">
        <title>Register</title>
    </head>
    <body>
        <div class="container registerConteneur">
            <h1 class="titleh1">Register</h1>
            <div class="form">
                <form id="register_form" method="post" action="register.fte">
                    <p>
                        <input id="login" type="text" name="login" placeholder="Login" value="<?php echo $login; ?>" autofocus="autofocus"/>
                    </p>
                    <p>
                        <input id="pswd" type="password" name="password" placeholder="Password" value="" />
                    </p>
                    <p>
                        <input id="pswd_check" type="password" name="password_check" placeholder="Password confirmation" value="" />
                    </p>
                    <p>
                        <input id="mail" type="text" name="mail" placeholder="mail" value="<?php echo $mail; ?>" />
                    </p>
                    <p class="logDiv">           
                        <?php
                        echo $label_err_login1;
                        echo $label_err_login2;
                        echo $label_err_password1;
                        echo $label_err_password2;
                        echo $label_err_mail;
                        ?>
                    </p>
                    <table style="width: 100%;">
                        <tr>
                            <td colspan="2" align="center">
                                <button type="submit" name="reg" form="register_form">Register</button>
                            </td>
                        <tr/>
                        <tr>
                            <td colspan="2" align="center">
                                <a href='index.fte'>Retour</a>
                            </td>
                        <tr/>
                    </table>
                </form>
            </div>
        </div>
    </body>
</html>
