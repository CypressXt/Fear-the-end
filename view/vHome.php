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
        <audio id="player" style="width: 48px;" loop ontimeupdate="info()">
            <source src="http://srcdata.vacau.com/fear-the-end/Mind_Heist.ogg" type="audio/ogg">
            <source src="http://srcdata.vacau.com/fear-the-end/Mind%20Heist.mp3" type="audio/mpeg">
            <!--<source src="http://srcdata.vacau.com/fear-the-end/Mission%20Impossible%20%20Injection.mp3" type="audio/mpeg">-->
            Your browser does not support the audio element.
        </audio>
        <progress id='progress' onclick="play()" value="0"></progress>
    </div>
</div>