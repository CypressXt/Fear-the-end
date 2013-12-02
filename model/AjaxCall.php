<?php

include_once "/home/cypress/www/htdocs/fear-the-end-secrets/sqlConnect.php";
include_once 'Member.php';
include_once 'MemberManager.php';
include_once 'Project.php';
include_once 'ProjectManager.php';


if ($_POST['methode'] == "addMemberTeam" && $_POST['projectID'] != "" && $_POST['idUserFunction'] != "" && $_POST['userName'] != "") {
    $projectID = $_POST['projectID'];
    $userName = $_POST['userName'];
    $memberFunction = $_POST['idUserFunction'];
    $memberManager = new MemberManager($db);
    $memberManager->linkMemberProject($projectID, $userName, $memberFunction, $memberManager);
}

if ($_POST['methode'] == "delMemberTeam" && $_POST['projectID'] != "" && $_POST['userName'] != "") {
    $projectID = $_POST['projectID'];
    $userName = $_POST['userName'];
    $memberManager = new MemberManager($db);
    $memberManager->unlinkMemberProject($projectID, $userName);
}


if ($_POST['methode'] == "changeProjectStatus" && $_POST['projectID'] != "" && $_POST['statusID'] != "") {
    $projectID = $_POST['projectID'];
    $statusID = $_POST['statusID'];
    $projectManager = new ProjectManager($db);
    $projectManager->changeProjectStatus($projectID, $statusID);
}
?>
