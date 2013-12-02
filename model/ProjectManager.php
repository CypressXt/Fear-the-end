<?php

class ProjectManager {

    private $_db;

//Constructor
//-----------

    public function __construct($db) {
        $this->setDb($db);
    }

//Setter
//------

    public function setDb(PDO $db) {
        $this->_db = $db;
    }

//Methods
//-------

    public function add(Project $project) {
        $q = $this->_db->prepare('INSERT INTO project SET title = :title, description = :description, introduction = :introduction, content = :content, image = :image, banner = :banner, fk_auteur = :fk_auteur,  date = :date, fk_status = :fk_status');
        $q->bindValue(':title', $project->getTitle(), PDO::PARAM_STR);
        $q->bindValue(':description', $project->getDescription(), PDO::PARAM_STR);
        $q->bindValue(':introduction', $project->getIntroduction(), PDO::PARAM_STR);
        $q->bindValue(':content', $project->getContent(), PDO::PARAM_STR);
        $q->bindValue(':image', $project->getImage(), PDO::PARAM_STR);
        $q->bindValue(':banner', $project->getBanner(), PDO::PARAM_STR);
        $q->bindValue(':fk_auteur', $project->getFk_auteur(), PDO::PARAM_STR);
        $q->bindValue(':date', $project->getDate(), PDO::PARAM_STR);
        $q->bindValue(':fk_status', 3, PDO::PARAM_INT);

        $q->execute();
        return $this->_db->lastInsertId();
    }

    public function getAllProject() {
        $allProject = array();
        $q = $this->_db->prepare('SELECT * FROM project inner join status_project on id_status = fk_status');
        $q->execute();

        while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
            $allProject[] = new Project($data);
        }
        return $allProject;
    }

    public function getAllProjectByAuteur($fk_auteur) {
        $allProject = array();
        $q = $this->_db->prepare('SELECT * FROM project inner join status_project on id_status = fk_status where fk_auteur =:fk_auteur');
        $q->bindValue(':fk_auteur', $fk_auteur, PDO::PARAM_STR);
        $q->execute();

        while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
            $allProject[] = new Project($data);
        }
        return $allProject;
    }

    public function getProjectById($projectID) {
        $q = $this->_db->prepare('SELECT * FROM r_tag_project
        inner join project on fk_project = id_project
        inner join tag on fk_tag = id_tag
        inner join status_project on id_status = fk_status
        WHERE id_project = :id');
        $q->bindValue(':id', $projectID, PDO::PARAM_STR);

        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $newProjet = new Project($data);
            $newProjet->setTag($this->getProjectTags($projectID));
            return $newProjet;
        } else {
            return new Project(array());
        }
    }

    public function getProjectTags($projectID) {
        $qTag = $this->_db->prepare('SELECT tag FROM r_tag_project
                inner join project on fk_project = id_project
                inner join tag on fk_tag = id_tag
                WHERE id_project = :id');
        $qTag->bindValue(':id', $projectID, PDO::PARAM_STR);
        $qTag->execute();


        $dataTags = $qTag->fetchAll(PDO::FETCH_NUM);
        $tags = $dataTags;
        return $tags;
    }

    public function getAllTags() {
        $allTags = array();
        $q = $this->_db->prepare('SELECT tag FROM tag');
        $q->execute();


        while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
            $allTags[] = $data;
        }
        return $allTags;
    }

    public function getProjectByTags($tag) {
        $allProject = array();
        $q = $this->_db->prepare('SELECT * FROM r_tag_project 
            inner join project on fk_project = id_project
            inner join tag on fk_tag = id_tag
            WHERE tag like :tag');
        $q->bindValue(':tag', $tag, PDO::PARAM_STR);
        $q->execute();

        while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
            $allProject[] = new Project($data);
        }
        return $allProject;
    }

    public function linkProjectAndtags($tags, $idNewProject) {
        $request = "SELECT * FROM `tag` WHERE";
        for ($i = 0; $i < count($tags); $i++) {
            if ($i == 0) {
                $request = $request . " tag like $tags[$i]";
            } else {
                $request = $request . " or tag like $tags[$i]";
            }
        }
        $q = $this->_db->prepare($request);
        $q->execute();

        $idTagsArray = array();
        $j = 0;
        while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
            $idTagsArray[$j] = $data['id_tag'];
            $j++;
        }

        $requestInsert = "INSERT into r_tag_project (fk_tag, fk_project) values";
        for ($b = 0; $b < count($idTagsArray); $b++) {
            if ($b == 0) {
                $requestInsertV = " ($idTagsArray[$b], $idNewProject) ";
            } else {
                $requestInsertV = $requestInsertV . ", " . "($idTagsArray[$b], $idNewProject) ";
            }
        }
        $finalRequest = $requestInsert . $requestInsertV;
        $q2 = $this->_db->prepare($finalRequest);
        $q2->execute() or die('Impossible D éxécuter la requete');
    }

    public function getAllStatus() {
        $allStatus = array();
        $q = $this->_db->prepare('SELECT * FROM status_project');
        $q->execute();


        while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
            $allStatus[] = $data;
        }
        return $allStatus;
    }
    
    public function changeProjectStatus($projectID, $statusID){
        $q = $this->_db->prepare('UPDATE `project` SET `fk_status`=:statusID WHERE `id_project` =:projectID ');
        $q->bindValue(':statusID', $statusID, PDO::PARAM_STR);
        $q->bindValue(':projectID', $projectID, PDO::PARAM_STR);
        $q->execute();        
    }

    public function getProjectByAutor($autor) {
        //NOT SUPPORTED YET
    }

}