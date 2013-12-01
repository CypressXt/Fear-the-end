<?php

class MemberManager {

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

    public function add(Member $member) {
        $q = $this->_db->prepare('INSERT INTO user SET login = :login, password = :password, mail = :mail');

        $q->bindValue(':login', $member->getLogin(), PDO::PARAM_STR);
        $q->bindValue(':password', $member->getPassword(), PDO::PARAM_STR);
        $q->bindValue(':mail', $member->getMail(), PDO::PARAM_STR);

        $q->execute();
    }

    public function delete(Member $member) {
        
    }

    public function update(Member $member) {
        
    }

    public function getId($login) {
        $q = $this->_db->prepare('SELECT id, login, password, mail FROM user WHERE login = :login');
        $q->bindValue(':login', $login, PDO::PARAM_STR);

        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new Member($data);
        } else {
            return new Member(array());
        }
    }

    public function getMembreById($id) {
        $q = $this->_db->prepare('SELECT id, login, password, mail FROM user WHERE id = :id');
        $q->bindValue(':id', $id, PDO::PARAM_STR);

        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new Member($data);
        } else {
            return new Member(array());
        }
    }

    public function getMembreByName($userName) {
        $q = $this->_db->prepare('SELECT * FROM user WHERE login like :login');
        $q->bindValue(':login', $userName, PDO::PARAM_STR);
        $q->execute();
        $data = $q->fetch(PDO::FETCH_ASSOC);
        //print_r($data);
        if ($data) {
            return new Member($data);
        } else {
            return new Member(array());
        }
    }

    public function getMembreByProject($projectID) {
        $memberArray = array();
        $i = 0;
        $q = $this->_db->prepare('SELECT * FROM `r_project_user` 
                                inner join user on id = fk_user
                                inner join project on id_project = fk_project
                                inner join user_function on id_function = fk_user_function 
                                where fk_project= :id');
        $q->bindValue(':id', $projectID, PDO::PARAM_STR);
        $q->execute();
        while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
            $memberArray[$i] = new Member($data);
            $i++;
        }
        return $memberArray;
    }

    public function getAllMemberFunction() {
        $functionArray = array();
        $i = 0;
        $q = $this->_db->prepare('SELECT * FROM  `user_function`');
        $q->execute();
        while ($data = $q->fetch(PDO::FETCH_ASSOC)) {
            $functionArray[$i] = $data;
            $i++;
        }
        return $functionArray;
    }

    public function linkMemberProject($projectID, $userName, $memberFunction) {
        $newMember = $this->getMembreByName($userName);
        if ($newMember != null) {
            $idUser = $newMember->getId();
            if ($projectID != "" && $idUser != "" && $memberFunction != "") {
                $q = $this->_db->prepare('INSERT INTO `r_project_user` 
                    (`fk_project`, `fk_user`, `fk_user_function`) VALUES (:projectID,:idUser,:memberFunction)');
                $q->bindValue(':projectID', $projectID, PDO::PARAM_STR);
                $q->bindValue(':idUser', $idUser, PDO::PARAM_STR);
                $q->bindValue(':memberFunction', $memberFunction, PDO::PARAM_STR);
                $q->execute();
            }
        }
    }

}