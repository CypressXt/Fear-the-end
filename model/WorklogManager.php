<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WorklogManager
 *
 * @author clement
 */
class WorklogManager {

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
    
    public function add(Worklog $worklog){
        $q = $this->_db->prepare('INSERT INTO `worklog` set title =:title, content =:content, fk_user =:fk_user, fk_project =:fk_project, date=NOW()');
        $q->bindValue(':title', $worklog->getTitle(), PDO::PARAM_STR);
        $q->bindValue(':content', $worklog->getContent(), PDO::PARAM_STR);
        $q->bindValue(':fk_user', $worklog->getFk_user(), PDO::PARAM_STR);
        $q->bindValue(':fk_project', $worklog->getFk_project(), PDO::PARAM_STR);
        $q->execute();
    }
    
    public function getAllWorklog(){
        $allWorklogs = array();
        $q = $this->_db->prepare('SELECT * FROM `worklog` order by date desc');
        $q->execute();

        while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
            $allWorklogs[] = new Worklog($data);
        }
        return $allWorklogs;
    }
    
}

?>
