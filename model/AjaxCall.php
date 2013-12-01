<?php

include_once "/home/cypress/www/htdocs/fear-the-end-secrets/sqlConnect.php";
include_once 'Member.php';
include_once 'MemberManager.php';


if ($_POST['methode'] == "addMemberTeam" && $_POST['projectID'] != "" && $_POST['idUserFunction'] != "" && $_POST['userName'] != "") {
    $projectID = $_POST['projectID'];
    $userName = $_POST['userName'];
    $memberFunction = $_POST['idUserFunction'];
    $memberManager = new MemberManager($db);
    $memberManager->linkMemberProject($projectID, $userName, $memberFunction, $memberManager);
}
?>
