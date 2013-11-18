<?php include_once 'model/Member.php'; ?>
<link rel="stylesheet" type="text/css" href="style/vWelcome.css">
<div class="vCenterCase">
    <h1 class="titleh1">
        Welcome <?php echo ucfirst(unserialize($_SESSION['loggedUserObject'])->getLogin()) ?>
    </h1><br/>
    <table width="90%" border="0" class="domainTable">
        <tr>
            <td class="imgTable">
                <a href="IT.fte"><img src="style/picture/it.jpg" height="160"></a>
            </td>
            <td class="imgTable">
                <a href="#"><img src="style/picture/game.jpg" height="160"></a>
            </td>
            <td class="imgTable">
                <a href="#"><img src="style/picture/musique.jpg" height="160"></a>
            </td>
        </tr>
        <tr>
            <td class="txtTable"><div class="txtTitleTable">IT</div><br>
                Technicals projects					
            </td>
            <td class="txtTable"><div class="txtTitleTable">Game</div><br>
                Gaming community					
            </td>
            <td class="txtTable"><div class="txtTitleTable">Media</div><br>
                Media peering					
            </td>
        </tr>
    </table>
    <br/>
    <center>
        <a href='controller/cLogout.php'>Logout</a>
    </center>
</div>