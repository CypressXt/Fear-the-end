<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <script type="text/javascript" src="javascript/fade.js"></script>
        <script type="text/javascript" src="javascript/player.js"></script>
        <script type="text/javascript" src="javascript/jquery.js"></script>
        <script type="text/javascript" src="javascript/popup.js"></script>
        <title>Fear the end</title>
        <meta name="viewport" content="width=device-width, initial-scale=0.0, minimum-scale=0.8, maximum-scale=2.0" />
    </head>
    <body onload="initAll(document.getElementById('player'), document.getElementById('log'), document.getElementById('progress'))">
        <?php
        include_once 'controller/cSession.php';
        ?>
    </body>
</html>