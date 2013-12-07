<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Worklog
 *
 * @author clement
 */
class Worklog {
    
    private $_id_worklog;
    private $_title;
    private $_content;
    private $_fk_user;
    private $_fk_project;
    private $_date;
    
    
    //Contructor
    public function __construct($data) {
        $this->hydrate($data);
    }
    
    
    // getters
    public function getId_worklog() {
        return $this->_id_worklog;
    }

    public function getTitle() {
        return $this->_title;
    }

    public function getContent() {
        return $this->_content;
    }

    public function getFk_user() {
        return $this->_fk_user;
    }

    public function getFk_project() {
        return $this->_fk_project;
    }

    public function getDate() {
        return $this->_date;
    }
    
    
    
    // setters
    public function setId_worklog($id_worklog) {
        $this->_id_worklog = $id_worklog;
    }

    public function setTitle($title) {
        $this->_title = $title;
    }

    public function setContent($content) {
        $this->_content = $content;
    }

    public function setFk_user($fk_user) {
        $this->_fk_user = $fk_user;
    }

    public function setFk_project($fk_project) {
        $this->_fk_project = $fk_project;
    }

    public function setDate($date) {
        $this->_date = $date;
    }

    
    //Hydrate function
    //----------------

    public function hydrate(array $data) {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }    
    
    
    
}

?>
