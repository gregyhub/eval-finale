<?php

class Chat {

    private $prenom;
    private $age;
    private $couleur;
    private $sexe;
    private $race;

    public function __construct($data = array())    {
        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    public function setPrenom($prenom)
    {
        if(strlen($prenom)<3 || strlen($prenom)>20){
            throw new Exception('Le prénom du chat doit faire entre 3 et 20 caractères');
        }else{
            $this->prenom = $prenom;
            return $this;
        }
    }

    public function setAge($age)
    {
        if(!is_numeric($age)){
            throw new Exception('l\'age doit etre un nombre');
        }else{
            $this->age = $age;
            return $this;
        }
    }

    public function setCouleur($couleur)
    {
        if(strlen($couleur)<3 || strlen($couleur)>10){
            throw new Exception('La couleur du chat doit faire entre 3 et 10 caractères');
        }else{
            $this->couleur = $couleur;
            return $this;
        }
    }

    public function setSexe($sexe)
    {
        if($sexe !="male" && $sexe != "femelle" ){
            throw new Exception('Le chat doit etre un "male" ou une "femelle"');
        }else{
            $this->sexe = $sexe;
            return $this;
        }
    }

    public function setRace($race)
    {
        if(strlen($race)<3 || strlen($race)>20){
            throw new Exception('La race du chat doit faire entre 3 et 20 caractères');
        }else{
            $this->race = $race;
            return $this;
        }
    }


    /**
     * Get the value of prenom
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Get the value of age
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Get the value of couleur
     */
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * Get the value of sexe
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Get the value of race
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     *  @return array
     */
    public function getInfo()
    {
       return get_object_vars($this);
    }
}