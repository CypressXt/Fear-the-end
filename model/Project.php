<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Project {

    private $_id_project;
    private $_title;
    private $_description;
    private $_introduction;
    private $_content;
    private $_banner;
    private $_image;
    private $_tag;
    private $_date;
    private $_fk_auteur;
    private $_status;

    public function __construct($data) {
        $this->hydrate($data);
    }

    //Setters

    public function setId_project($id_project) {
        $this->_id_project = $id_project;
    }

    public function setTitle($title) {
        $this->_title = $title;
    }

    public function setDescription($description) {
        $this->_description = $description;
    }

    public function setIntroduction($introduction) {
        $this->_introduction = $introduction;
    }

    public function setContent($content) {
        $this->_content = $content;
    }

    public function setBanner($banner) {
        $this->_banner = $banner;
    }

    public function setImage($image) {
        $this->_image = $image;
    }

    public function setTag($tag) {
        $this->_tag = $tag;
    }

    public function setDate($date) {
        $this->_date = $date;
    }

    public function setFk_auteur($fk_auteur) {
        $this->_fk_auteur = $fk_auteur;
    }

    public function setFk_status($fk_status) {
        $this->_fk_status = $fk_status;
    }

    public function setStatus($status) {
        $this->_status = $status;
    }

    //Getter

    public function getId() {
        return $this->_id_project;
    }

    public function getTitle() {
        return $this->_title;
    }

    public function getDescription() {
        return $this->_description;
    }

    public function getIntroduction() {
        return $this->_introduction;
    }

    public function getContent() {
        return $this->_content;
    }

    public function getBanner() {
        return $this->_banner;
    }

    public function getImage() {
        return $this->_image;
    }

    public function getTag() {
        return $this->_tag;
    }

    public function getDate() {
        return $this->_date;
    }

    public function getFk_auteur() {
        return $this->_fk_auteur;
    }

    public function getId_project() {
        return $this->_id_project;
    }

    public function getFk_status() {
        return $this->_fk_status;
    }

    public function getStatus() {
        return $this->_status;
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