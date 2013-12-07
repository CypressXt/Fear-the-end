<?php

include_once "/home/cypress/www/htdocs/fear-the-end-secrets/sqlConnect.php";
include_once '../model/Member.php';
include_once '../model/MemberManager.php';
include_once '../model/Project.php';
include_once '../model/ProjectManager.php';
include_once '../model/Worklog.php';
include_once '../model/WorklogManager.php';


if ($_POST['methode'] == "addMemberTeam" && $_POST['projectID'] != "" && $_POST['idUserFunction'] != "" && $_POST['userName'] != "") {
    $projectID = $_POST['projectID'];
    $userName = $_POST['userName'];
    $memberFunction = $_POST['idUserFunction'];
    $memberManager = new MemberManager($db);
    $memberManager->linkMemberProject($projectID, $userName, $memberFunction, $memberManager);
}

if ($_POST['methode'] == "delMemberTeam" && $_POST['projectID'] != "" && $_POST['userFunctionID'] != "" && $_POST['userName'] != "") {
    $projectID = $_POST['projectID'];
    $userName = $_POST['userName'];
    $userFunctionID = $_POST['userFunctionID'];
    $memberManager = new MemberManager($db);
    $memberManager->unlinkMemberProject($projectID, $userFunctionID, $userName);
}


if ($_POST['methode'] == "changeProjectStatus" && $_POST['projectID'] != "" && $_POST['statusID'] != "") {
    $projectID = $_POST['projectID'];
    $statusID = $_POST['statusID'];
    $projectManager = new ProjectManager($db);
    $projectManager->changeProjectStatus($projectID, $statusID);
}

if ($_POST['methode'] == "newWorklog" && $_POST['projectID'] != "" && $_POST['userID'] != "" && $_POST['workLogTitle'] != "" && $_POST['workLogContent'] != "") {
    $projectID = $_POST['projectID'];
    $userID = $_POST['userID'];
    $workLogTitle = $_POST['workLogTitle'];
    $workLogContent = $_POST['workLogContent'];
    $workLogManager = new WorklogManager($db);
    $dataWorklog = array(
            'title' => $workLogTitle,
            'content' => $workLogContent,
            'fk_user' => $userID,
            'fk_project' => $projectID);
    $worklog = new Worklog($dataWorklog);
    $workLogManager->add($worklog);
}
?>