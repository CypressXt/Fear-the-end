<?php

include_once '/home/cypress/www/htdocs/fear-the-end-secrets/ftp.php';
include_once 'model/Project.php';
include_once 'model/ProjectManager.php';
include_once 'model/MemberManager.php';
include_once 'model/Member.php';

$label_err_projectName = "";
$label_err_projectTechnologie = "";
$label_err_projectSlogant = "";
$label_err_projectDescription = "";
$label_err_projectFileBann = "";
$label_err_projectFilePict = "";
$uploadPictureRDY = false;
$uploadBannerRDY = false;

$projectManager = new ProjectManager($db);
$memberManager = new MemberManager($db);


// adding new project after formular completion
if (isset($_POST['publish']) && $_SESSION && !isset($_GET['subpage'])) {
    $ok = true;
    $title = $_POST['title'];
    $date = date("Y-m-d H:i:s");
    $tags = $_POST['tags'];
    $description = $_POST['description'];
    $introduction = $_POST['introduction'];
    $content = $_POST['content'];
    $fk_auteur = unserialize($_SESSION['loggedUserObject'])->getId();
    // upload de la bannière
    $bannerExtension = strtolower(substr(strrchr($_FILES['bannFile']['name'], '.'), 1));
    $fileNameBann = "BanUser" . $_SESSION['logedUserID'] . $title . "." . $bannerExtension;
    $cachedFileBann = $_FILES['bannFile']['tmp_name'];

    //upload de l'image de projet
    $PicExtension = strtolower(substr(strrchr($_FILES['pictFile']['name'], '.'), 1));
    $fileNamePict = "PicUser" . $_SESSION['logedUserID'] . $title . "." . $PicExtension;
    $cachedFilePict = $_FILES['pictFile']['tmp_name'];



    if (strlen($title) > 20 || empty($title)) {
        $label_err_projectName = "Invalid project Name ! (max 20 chars)<br/>";
        $ok = FALSE;
    }

    if (empty($tags)) {
        $label_err_projectTechnologie = "Invalid project technologie !<br/>";
        $ok = FALSE;
    }

    if (empty($description)) {
        $label_err_projectSlogant = "Invalid project slogant !<br/>";
        $ok = FALSE;
    }

    if (empty($content)) {
        $label_err_projectDescription = "Invalid project description !<br/>";
        $ok = FALSE;
    }


    if (empty($cachedFilePict)) {
        $label_err_projectFilePict = "Invalid project picture !<br/>";
        $fileNamePict = "defaultPicture.png";
    } else {
        $uploadPictureRDY = true;
    }

    if (empty($cachedFileBann)) {
        $label_err_projectFilePict = "Invalid project banner !<br/>";
        $fileNameBann = "defaultBanner.jpg";
    } else {
        $uploadBannerRDY = true;
        list($wBan, $hBan, $typeBan, $attrBan) = getimagesize($cachedFileBann);
        if (empty($cachedFileBann) || $wBan > 1200 || $hBan > 400) {
            $label_err_projectFileBann = "Invalid project banner (size 1200x400px) !<br/>
                                          Image size " . $wBan . "px - " . $hBan . "</br>" . $fileNameBann;
            $ok = FALSE;
        }
    }

    if ($ok) {
        $dataProject = array(
            'title' => $title,
            'description' => $description,
            'introduction' => $introduction,
            'content' => $content,
            'banner' => "http://srcdata.vacau.com/fear-the-end/datas/$fileNameBann",
            'image' => "http://srcdata.vacau.com/fear-the-end/datas/$fileNamePict",
            'tag' => $tags,
            'date' => $date,
            'fk_auteur' => $fk_auteur);

        if ($uploadBannerRDY == true) {
            upload($fileNameBann, $cachedFileBann);
        }

        if ($uploadPictureRDY == true) {
            upload($fileNamePict, $cachedFilePict);
        }

        //tags management:
        $tags = str_replace("[", "", $tags);
        $tags = str_replace("]", "", $tags);
        $tagsArray = explode(",", $tags);

        $newProject = new Project($dataProject);
        $idNewProject = $projectManager->add($newProject);
        $projectManager->linkProjectAndtags($tagsArray, $idNewProject);
        header('Location: http://fear-the-end.com/IT.fte');
    } else {
        $label_err = 'Error while creating the new project ! <br>';
        $label_err = $label_err . $label_err_projectName . "<br>";
        $label_err = $label_err . $label_err_projectTechnologie . "<br>";
        $label_err = $label_err . $label_err_projectSlogant . "<br>";
        $label_err = $label_err . $label_err_projectDescription . "<br>";
        $label_err = $label_err . $label_err_projectFileBann . "<br>";
        $label_err = $label_err . $label_err_projectFilePict . "<br>";
        include_once 'model/popup.php';
    }
}


if (isset($_GET['id']) && !isset($_GET['subpage'])) {
    $projectShowed = $projectManager->getProjectById($_GET['id']);
    $date = date_create($projectShowed->getDate());
    $dateFormated = date_format($date, "d.m.Y");
    $autName = $memberManager->getMembreById($projectShowed->getFk_auteur())->getLogin();
    $urlActuel = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $description = $projectShowed->getDescription();
    $introduction = $projectShowed->getIntroduction();
    $content = $projectShowed->getContent();
    include_once 'view/vIT_Project.php';
} else if ($_GET['l'] == "newProject") {
    if ($_SESSION) {
        $tagsList = "";
        $allTags = $projectManager->getAllTags();
        foreach ($allTags as $tag) {
            if ($tagsList != "") {
                $tagsList = $tagsList . "," . $tag[tag];
            } else {
                $tagsList = $tag[tag];
            }
        }
        include_once 'view/vIT_NewProject.php';
    } else {
        header('Location: http://fear-the-end.com/');
    }
}


//###########################
//displaying selected project
//###########################
//displaying project's team
if ($_GET['l'] == "project" && isset($_GET['id']) && $_GET['subpage'] == "team") {
    $projectShowed = $projectManager->getProjectById($_GET['id']);
    $date = date_create($projectShowed->getDate());
    $dateFormated = date_format($date, "d.m.Y");
    $autName = $memberManager->getMembreById($projectShowed->getFk_auteur())->getLogin();
    $description = "Project's Team";
    $userArray = $memberManager->getMembreByProject($_GET['id']);
    $intro = userArrayToHTML($userArray, $projectManager);
    $introduction = $intro;
    $content = newTeamUser($memberManager, $projectManager);
    include_once 'view/vIT_Project.php';
}

// Displaying all members with their functions
function userArrayToHTML($userArray, ProjectManager $projectManager) {
    $projectShowed = $projectManager->getProjectById($_GET['id']);
    $html = '';
    $table = "<table class=\"tableTeamMembers\">";
    if ($_SESSION['loggedUserObject'] != null && unserialize($_SESSION['loggedUserObject'])->getId() == $projectShowed->getFk_auteur()) {
        for ($nb = 0; $nb < count($userArray); $nb++) {
            $table = $table . "<tr>
                            <td>" . ucfirst($userArray[$nb]->getLogin()) . "</td>
                            <td>" . $userArray[$nb]->getFunction() . "</td>" .
                    '<td>
                                <input class="btn center blue" value="Remove" onclick="delMemberTeam(' . $_GET['id'] . ',\'' . $userArray[$nb]->getLogin() . '\')">
                            </td>'
                    . "</tr>";
        }
    } else {
        for ($nb = 0; $nb < count($userArray); $nb++) {
            $table = $table . "<tr>
                            <td>" . ucfirst($userArray[$nb]->getLogin()) . "</td>
                            <td>" . $userArray[$nb]->getFunction() . "</td>
                         </tr>";
        }
    }
    $html = $html . $table . "</table>";
    return $html;
}

// Create a select with all member"s functions
function newTeamUser(MemberManager $memberManager, ProjectManager $projectManager) {
    $projectShowed = $projectManager->getProjectById($_GET['id']);
    if ($_SESSION['loggedUserObject'] != null && unserialize($_SESSION['loggedUserObject'])->getId() == $projectShowed->getFk_auteur()) {
        $functionArray = $memberManager->getAllMemberFunction();
        $html = '
                <table>
                    <tr>
                        <td><label for="memberMail">Add a new team member:</label></td>
                    </tr>
                    <tr>
                        <td><input id="userName" type="text" name="userName" placeholder="username" value="" /></td>
                        <td>
                            <select id="roles" name="roles" class="styled-select">';
        for ($i = 0; $i < count($functionArray); $i++) {
            if ($functionArray[$i]['function'] == "Developer") {
                $html = $html . '<option selected value="' . $functionArray[$i]['id_function'] . '">' . $functionArray[$i]['function'] . '</option>';
            } else {
                $html = $html . '<option value="' . $functionArray[$i]['id_function'] . '">' . $functionArray[$i]['function'] . '</option>';
            }
        }
        $html = $html . '</select>
                        </td>
                        <td>
                            <input name="addTeam" class="btn center blue" value="Add" onclick="addMemberTeam(' . $_GET['id'] . ',document)">
                        </td>
                    </tr>
                </table>
             ';
    } else {
        $html = "<p>You need to own this project before adding new members</p>";
    }
    return $html;
}