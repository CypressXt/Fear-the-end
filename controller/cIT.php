<?php

include_once 'model/Project.php';
include_once 'model/ProjectManager.php';
include_once 'model/Member.php';

$colonne1 = array();
$colonne2 = array();
$colonne3 = array();
$colonne1HTML = array();
$colonne2HTML = array();
$colonne3HTML = array();
$projectManager = new ProjectManager($db);


if ($_GET['l'] == "IT") {

    $projectList = $projectManager->getAllProject();
    $nbCol = 1;
    for ($i = 0; $i < sizeof($projectList); $i++) {
        $project = $projectList[$i];
        if ($nbCol == 1) {
            $colonne1[] = $project;
        }

        if ($nbCol == 2) {
            $colonne2[] = $project;
        }

        if ($nbCol == 3) {
            $colonne3[] = $project;
            $nbCol = 1;
        }

        $nbCol++;
    }

    $colonne1HTML = printColonne($colonne1);
    $colonne2HTML = printColonne($colonne2);
    $colonne3HTML = printColonne($colonne3);

    include_once 'view/vIT.php';
}


if ($_GET['l'] == "ownIT" && $_SESSION['loggedUserObject']) {
    $idUserLoged = unserialize($_SESSION['loggedUserObject'])->getId();
    $projectList = $projectManager->getAllProjectByAuteur($idUserLoged);
    $nbCol = 1;
    for ($i = 0; $i < sizeof($projectList); $i++) {
        $project = $projectList[$i];
        if ($nbCol == 1) {
            $colonne1[] = $project;
        }

        if ($nbCol == 2) {
            $colonne2[] = $project;
        }

        if ($nbCol == 3) {
            $colonne3[] = $project;
            $nbCol = 1;
        }

        $nbCol++;
    }

    $colonne1HTML = printColonne($colonne1);
    $colonne2HTML = printColonne($colonne2);
    $colonne3HTML = printColonne($colonne3);
    include_once 'view/vIT.php';
} else {
    if ($_GET['l'] == "ownIT" && !$_SESSION['loggedUserObject']) {
        header('Location: http://fear-the-end.com/');
    }
}

if ($_GET['l'] == "projectByTag") {
    $projectList = $projectManager->getProjectByTags($_GET['tag']);
    $nbCol = 1;
    for ($i = 0; $i < sizeof($projectList); $i++) {
        $project = $projectList[$i];
        if ($nbCol == 1) {
            $colonne1[] = $project;
        }

        if ($nbCol == 2) {
            $colonne2[] = $project;
        }

        if ($nbCol == 3) {
            $colonne3[] = $project;
            $nbCol = 1;
        }

        $nbCol++;
    }
    $colonne1HTML = printColonne($colonne1);
    $colonne2HTML = printColonne($colonne2);
    $colonne3HTML = printColonne($colonne3);
    include_once 'view/vIT.php';
}

function printColonne($colonne) {
    for ($t = 0; $t < sizeof($colonne); $t++) {
        $colonneHTML[$t] = "<a href=\"/project/" .$colonne[$t]->getId(). "\">
                                <div class=\"projectDiv\">
                                    <h1>" . $colonne[$t]->getTitle() . "</h1>
                                    <table>
                                        <tr>
                                            <td>
                                                <img src=\"" . $colonne[$t]->getImage() . "\" />
                                            </td>
                                            <td>
                                                <p>" . $colonne[$t]->getDescription() . "</p>
                                                <p>" . $colonne[$t]->getStatus() . "</p>
                                                <p>" . date_format(date_create($colonne[$t]->getDate()), "d.m.Y") . "</p>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </a>";
    }
    return $colonneHTML;
}