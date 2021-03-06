<?php

class Member
{
    private $_id;
    private $_login;
    private $_password;
    private $_mail;
    private $_function;
    
    // Setters
    //--------

    public function setId($id)
    {
            $this->_id = $id;
    }
    
    public function setLogin($login)
    {
            $this->_login = $login;
    }

    public function setPassword($password)
    {
        $this->_password = $password;
    }
    
    public function setMail($mail)
    {
        $this->_mail = $mail;
    }
    
    public function getFunction() {
        return $this->_function;
    }

        
    
    //Getters
    //-------
    
    public function getId()
    {
        return $this->_id;
    }
    
    public function getLogin()
    {
        return $this->_login;
    }
    
    public function getPassword()
    {
        return $this->_password;
    }
    
    public function getMail()
    {
        return $this->_mail;
    }
    
    public function setFunction($function) {
        $this->_function = $function;
    }

    //Constructor
    //-----------
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }
    
    //Hydrate function
    //----------------
    
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value)
        {
            $method = 'set'.ucfirst($key);
            
            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }
}