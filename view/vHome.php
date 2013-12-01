<div class="container loginConteneur" id="fade">
    <h1 class="titleh1">
        Login
    </h1>
    <div id="log">
        <div class="form">
            <form id="login_form" method="post" action="">
                <p>
                    <input id="login" type="text" name="login" placeholder="Login" value="" autofocus="autofocus"/>
                </p>
                <p>
                    <input id="password" type="password" name="password" placeholder="Password" value="" />
                </p>
                <table>
                    <tr>
                        <td  width="120px" colspan="2" align="center">
                            <button type="submit" name="auth" form="login_form" class="show-popup">Login</button>
                        </td>
                        <td colspan="2" align="center">
                            <a href="register.fte">Register</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <!-- WE DO NOT OWN THESE SOUNDS !! -->
        <audio id="player" style="width: 48px;" loop ontimeupdate="info()">
            <?php
            $rand = rand(0, 2);

            if ($rand == 0) {
                ?>
                <source src="http://srcdata.vacau.com/fear-the-end/Mind_Heist.ogg" type="audio/ogg">
                <source src="http://srcdata.vacau.com/fear-the-end/Mind%20Heist.mp3" type="audio/mpeg">
            <?
            }

            if ($rand == 1) {
                ?>
                <source src="http://srcdata.vacau.com/fear-the-end/Why_Do_We_Fall.ogg" type="audio/ogg">
                <source src="http://srcdata.vacau.com/fear-the-end/Why%20Do%20We%20Fall.mp3" type="audio/mpeg">
            <?
            }

            if ($rand == 2) {
                ?>
                <source src="http://srcdata.vacau.com/fear-the-end/clubbed_to_death.ogg" type="audio/ogg">
                <source src="http://srcdata.vacau.com/fear-the-end/clubbed%20to%20death.mp3.mp3" type="audio/mpeg">
            <? }?>

            Your browser does not support the audio element.
        </audio>
        <progress id='progress' onclick="play()" value="0"></progress>
    </div>
</div>