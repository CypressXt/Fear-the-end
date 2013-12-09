<?php

include_once '/home/cypress/www/htdocs/fear-the-end-secrets/ftp.php';
include_once 'model/Project.php';
include_once 'model/ProjectManager.php';
include_once 'model/MemberManager.php';
include_once 'model/Member.php';
include_once 'model/Worklog.php';
include_once 'model/WorklogManager.php';

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
        $label_err_projectName = "Invalid project Name ! (max 20 chars)<br/><br/>";
        $ok = FALSE;
    }

    if (empty($tags)) {
        $label_err_projectTechnologie = "Invalid project technologie !<br/><br/>";
        $ok = FALSE;
    }

    if (empty($description)) {
        $label_err_projectSlogant = "Invalid project slogant !<br/><br/>";
        $ok = FALSE;
    }

    if (empty($content)) {
        $label_err_projectDescription = "Invalid project description !<br/><br/>";
        $ok = FALSE;
    }


    if (empty($cachedFilePict)) {
        $label_err_projectFilePict = "(The default project picture is used)<br/>";
        $fileNamePict = "defaultPicture.png";
    } else {
        $uploadPictureRDY = true;
    }

    if (empty($cachedFileBann)) {
        $label_err_projectFileBann = "(The default project banner is used)<br/>";
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
        $label_err = '<h4>Error while creating the new project !</h4>';
        $label_err = $label_err . $label_err_projectName;
        $label_err = $label_err . $label_err_projectTechnologie;
        $label_err = $label_err . $label_err_projectSlogant;
        $label_err = $label_err . $label_err_projectDescription;
        $label_err = $label_err . $label_err_projectFileBann;
        $label_err = $label_err . $label_err_projectFilePict;
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
    $intro = userArrayToHTML($userArray, $projectManager, $memberManager);
    $introduction = $intro;
    $content = newTeamUser($memberManager, $projectManager);
    include_once 'view/vIT_Project.php';
}


//displaying project about
if ($_GET['l'] == "project" && isset($_GET['id']) && $_GET['subpage'] == "about") {
    $projectShowed = $projectManager->getProjectById($_GET['id']);
    $date = date_create($projectShowed->getDate());
    $dateFormated = date_format($date, "d.m.Y");
    $autName = $memberManager->getMembreById($projectShowed->getFk_auteur())->getLogin();
    $userArray = $memberManager->getMembreByProject($_GET['id']);




    $description = "Project About";
    $introduction = getProjectStatus($projectShowed);
    $content = changeProjectStatus($projectShowed, $projectManager);
    include_once 'view/vIT_Project.php';
}

//displaying project's media
if ($_GET['l'] == "project" && isset($_GET['id']) && $_GET['subpage'] == "media") {
    $projectShowed = $projectManager->getProjectById($_GET['id']);
    $date = date_create($projectShowed->getDate());
    $dateFormated = date_format($date, "d.m.Y");
    $autName = $memberManager->getMembreById($projectShowed->getFk_auteur())->getLogin();
    $userArray = $memberManager->getMembreByProject($_GET['id']);




    $description = "Project's Media";
    $introduction = "";
    $content = "";
    include_once 'view/vIT_Project.php';
}

//displaying project's worklog
if ($_GET['l'] == "project" && isset($_GET['id']) && $_GET['subpage'] == "worklog") {
    $projectShowed = $projectManager->getProjectById($_GET['id']);
    $date = date_create($projectShowed->getDate());
    $dateFormated = date_format($date, "d.m.Y");
    $autName = $memberManager->getMembreById($projectShowed->getFk_auteur())->getLogin();
    $userArray = $memberManager->getMembreByProject($_GET['id']);




    $description = newWorklogFormular();
    $introduction = displayAllWorklogs($db);
    $content = "";
    include_once 'view/vIT_Project.php';
}

//###########################
//display helpers functions
//###########################
// Displaying all members with their functions
function userArrayToHTML($userArray, ProjectManager $projectManager, MemberManager $memberManager) {
    $html = '';
    $table = "<table class=\"tableTeamMembers\">";
    if (checkUserAutority()) {
        for ($nb = 0; $nb < count($userArray); $nb++) {
            $table = $table . "<tr>
                            <td>" . ucfirst($userArray[$nb]->getLogin()) . "</td>
                            <td>" . $userArray[$nb]->getFunction() . "</td>" .
                    '<td>
                                <input class="btn center blue" value="Remove" onclick="delMemberTeam(' . $_GET['id'] . ',' . $memberManager->getFunctionID($userArray[$nb]->getFunction()) . ',\'' . $userArray[$nb]->getLogin() . '\')">
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
    if (checkUserAutority()) {
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

// display the status of a project
function getProjectStatus(Project $project) {
    $html = "State: ";
    $html = $html . $project->getStatus();
    return $html;
}

// Create a select with all project's status
function changeProjectStatus(Project $project, ProjectManager $projectManager) {
    $statusArray = $projectManager->getAllStatus();
    if (checkUserAutority()) {
        $html = '
                <table>
                    <tr>
                        <td><label for="memberMail">Change the project status:</label></td>
                    </tr>
                    <tr>
                        <td>
                            <select id="status" name="status" class="styled-select">';
        for ($i = 0; $i < count($statusArray); $i++) {
            if ($statusArray[$i]['status'] == "Recruiting") {
                $html = $html . '<option selected value="' . $statusArray[$i]['id_status'] . '">' . $statusArray[$i]['status'] . '</option>';
            } else {
                $html = $html . '<option value="' . $statusArray[$i]['id_status'] . '">' . $statusArray[$i]['status'] . '</option>';
            }
        }
        $html = $html . '</select>
                        </td>
                        <td>
                            <input name="changeStatus" class="btn center blue" value="Change" onclick="changeProjectStatus(' . $_GET['id'] . ',document)">
                        </td>
                    </tr>
                </table>
             ';
    } else {
        $html = "<p>You need to own this project before changing its state.</p>";
    }
    return $html;
}

//Display a formular for adding new worklogs
function newWorklogFormular() {
    $html = "Project's Worklog</br></br>";

    if (checkUserAutority()) {
        $idUser = unserialize($_SESSION['loggedUserObject'])->getId();
        $idProject = $_GET['id'];
        $html = $html . '
            <form>
                <label for="title">Title</label>
                <input id="title" type="text" name="title"/></br></br>
                <label for="content">Content</label>
                <textarea id="contentWorklog" name="contentWorklog" class="mce"></textarea>
                <button type="submit" onclick="newWorklog(' . $idProject . ',' . $idUser . ',document)" class="btn center blue">Créer</button>
            </form>
        ';
    }
    return $html;
}

function displayAllWorklogs($db){
    $html = "";
    $worklogManager = new WorklogManager($db);
    $memberManager = new MemberManager($db);
    $projectManager = new ProjectManager($db);
    $project = $projectManager->getProjectById($_GET['id']);
    $worklogArray = $worklogManager->getAllWorklogByProject($project);
    for($i = 0; $i<count($worklogArray);$i++){
        $writer =  ucfirst($memberManager->getMembreById($worklogArray[$i]->getFk_user())->getLogin());
        $date = date_create($worklogArray[$i]->getDate());
        $dateFormated = date_format($date, "d.m.Y h:i");
        $html = $html.'
            <div class="worklog">
                <div class="info">Writer: '.$writer.' | Date: '.$dateFormated.'</div>
                <div class="content">
                    '.$worklogArray[$i]->getContent().'
                </div>
            </div>
        ';
    }
    
    return $html;
}

// check if the loged user as the autority on the current project
function checkUserAutority() {
    include "/home/cypress/www/htdocs/fear-the-end-secrets/sqlConnect.php";
    $projectManager = new ProjectManager($db);
    $memberManager = new MemberManager($db);
    $project = $projectManager->getProjectById($_GET['id']);
    $isDeveloper = false;
    $userArrayOnProject = $memberManager->getMembreByProject($project->getId());
    for ($i = 0; $i < count($userArrayOnProject); $i++) {
        if ($_SESSION['loggedUserObject'] != null && ($userArrayOnProject[$i]->getId() == unserialize($_SESSION['loggedUserObject'])->getId()) && ($userArrayOnProject[$i]->getFunction() == "Developer")) {
            $isDeveloper = true;
        }
    }

    $res = false;
    if (($_SESSION['loggedUserObject'] != null && unserialize($_SESSION['loggedUserObject'])->getId() == $project->getFk_auteur()) || $isDeveloper) {
        $res = true;
    } else {
        $res = false;
    }
    return $res;
}