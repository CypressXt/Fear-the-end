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
            $label_err_projectFileBann = "Invalid project banner (size 1200x400px) !<br/>Image size " . $wBan . "px - " . $hBan . "</br>" . $fileNameBann;
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
        echo 'Error while uploading the new project ! <br>';
        echo $label_err_projectName . "<br>";
        echo $label_err_projectTechnologie . "<br>";
        echo $label_err_projectSlogant . "<br>";
        echo $label_err_projectDescription . "<br>";
        echo $label_err_projectFileBann . "<br>";
        echo $label_err_projectFilePict . "<br>";
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
        $allTags = array();
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
    $intro = userArrayToHTML($userArray);
    $introduction = $intro;
    $content = newTeamUser($memberManager);
    include_once 'view/vIT_Project.php';
}

function userArrayToHTML($userArray) {
    $html = '';
    $table = "<table>";
    for($nb = 0; $nb < count($userArray); $nb++){
        $table = $table."<tr>
                            <td>".$userArray[$nb]->getLogin()."</td>
                            <td>".$userArray[$nb]->getFunction()."</td>
                         </tr>";
    }
    $html = $html.$table."</table>" ;
    return $html;
}


function newTeamUser(MemberManager $memberManager){
    $functionArray = array();
    $functionArray = $memberManager->getAllMemberFunction();
    $html = '<form>
                <table>
                    <tr>
                        <td><label for="memberMail">Add a new team member:</label></td>
                    </tr>
                    <tr>
                        <td><input id="memberMail" type="text" name="memberMail" placeholder="contact@email.com" value="" /></td>
                        <td>
                            <select name="roles">';
                                for($i = 0; $i < count($functionArray); $i++){
                                   $html = $html.'<option>'.$functionArray[$i]['function'].'</option>'; 
                                }
     $html = $html.         '</select>
                        </td>
                    </tr>
                </table>
             </form>';
    return $html;
}