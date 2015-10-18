<?php

/*
 * Model of education degrees. Handles validation of parameters,
 * creation and database queries.
 */

class Degree extends BaseModel {

    public $id, $name, $deadline, $description,
    $accepted, $acceptancerate, $city, $extent, $institutions;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_description', 'validate_city', 'validate_extent',
            'validate_acceptancerate', 'validate_institutions');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Degree');
        $query->execute();
        $rows = $query->fetchAll();
        $degrees = array();

        foreach ($rows as $row) {
            $query= DB::connection()->prepare('SELECT * FROM Degree_Institution WHERE degree_id = :id');
            $query->execute(array('id' => $row['id']));
            $degree_institutions = $query->fetchAll();
            $institutions = array();
            foreach($degree_institutions as $degree_institution){
                $institutions[] = Institution::find($degree_institution['institution_id']);
            }
            $degrees[] = new Degree(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'deadline' => $row['deadline'],
                'description' => $row['description'],
                'accepted' => $row['accepted'],
                'acceptancerate' => $row['acceptancerate'],
                'city' => $row['city'],
                'extent' => $row['extent'],
                'institutions' => $institutions
                ));
        }
        return $degrees;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Degree WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $query= DB::connection()->prepare('SELECT * FROM Degree_Institution WHERE degree_id = :id');
            $query->execute(array('id' => $row['id']));
            $degree_institutions = $query->fetchAll();
            $institutions = array();
            foreach ($degree_institutions as $degree_institution) {
                $institution = Institution::find($degree_institution['institution_id']);
                $institutions[] = $institution;
            }
            $degree = new Degree(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'deadline' => $row['deadline'],
                'description' => $row['description'],
                'accepted' => $row['accepted'],
                'acceptancerate' => $row['acceptancerate'],
                'city' => $row['city'],
                'extent' => $row['extent'],
                'institutions' => $institutions
                ));
            return $degree;
        }

        return null;
    }

    public static function search($city, $accepted_max, $accepted_min, $extent_max, $extent_min){
        if(strlen($city) == 0){
            $query = DB::connection()->prepare('SELECT * FROM Degree WHERE acceptancerate <= :accepted_max AND acceptancerate >= :accepted_min AND extent <= :extent_max AND extent >= :extent_min');
            $query->execute(array('accepted_max' => $accepted_max, 'accepted_min' => $accepted_min, 'extent_max' => $extent_max, 'extent_min' => $extent_min));
        } else {
            $query = DB::connection()->prepare('SELECT * FROM Degree WHERE city= :city AND acceptancerate <= :accepted_max AND acceptancerate >= :accepted_min AND extent <= :extent_max AND extent >= :extent_min');
            $query->execute(array('city' => $city, 'accepted_max' => $accepted_max, 'accepted_min' => $accepted_min, 'extent_max' => $extent_max, 'extent_min' => $extent_min));
        }
        
        $rows = $query->fetchAll();

        $degrees = array();
        foreach ($rows as $row) {
            $query= DB::connection()->prepare('SELECT * FROM Degree_Institution WHERE degree_id = :id');
            $query->execute(array('id' => $row['id']));
            $degree_institutions = $query->fetchAll();
            $institutions = array();
            foreach($degree_institutions as $degree_institution){
                $institutions[] = Institution::find($degree_institution['institution_id']);
            }
            $degrees[] = new Degree(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'deadline' => $row['deadline'],
                'description' => $row['description'],
                'accepted' => $row['accepted'],
                'acceptancerate' => $row['acceptancerate'],
                'city' => $row['city'],
                'extent' => $row['extent'],
                'institutions' => $institutions
                ));
        }
        return $degrees;
    }

    public static function findByInstitution($id){
        $query= DB::connection()->prepare('SELECT * FROM Degree_Institution WHERE institution_id = :id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();
        $degrees = array();
        foreach ($rows as $row) {
            $degrees[] = self::find($row['degree_id']);
        }
        return $degrees;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Degree (name, description, deadline, accepted, acceptancerate, city, extent) VALUES (:name, :description, :deadline, :accepted, :acceptancerate, :city, :extent) RETURNING id');
        $query->execute(array('name' => $this->name, 'description' => $this->description, 'deadline' => $this->deadline, 'accepted'=>$this->accepted, 'acceptancerate' => $this->acceptancerate, 'city' => $this->city, 'extent' => $this->extent));
        $row = $query->fetch();
        $this->id = $row['id'];
    }

    public function saveInstitutions($institutions){
        foreach ($institutions as $institutionId) {
            $query = DB::connection()->prepare('INSERT INTO Degree_Institution(degree_id, institution_id) VALUES (:degree_id, :institution_id)');
            $query->execute(array('degree_id' => $this->id, 'institution_id' => $institutionId));
        }
    }
    
    public function update() {
        $query = DB::connection()->prepare('UPDATE Degree SET name= :name, description= :description, deadline= :deadline, accepted= :accepted, acceptancerate= :acceptancerate, city= :city, extent= :extent WHERE id = :id');
        $query->execute(array('id' => $this->id, 'name' => $this->name, 'description' => $this->description, 'deadline' => $this->deadline, 'accepted'=>$this->accepted, 'acceptancerate' => $this->acceptancerate, 'city' => $this->city, 'extent' => $this->extent));
    }

    public function updateInstitutions($institutionIds){
        $query = DB::connection()->prepare('DELETE FROM Degree_Institution WHERE degree_id= :id');
        $query->execute(array('id' => $this->id));
        $this->saveInstitutions($institutionIds);
    }
    
    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Degree_Institution WHERE degree_id= :id');
        $query->execute(array('id' => $this->id));
        $query = DB::connection()->prepare('DELETE FROM Degree WHERE id= :id');
        $query->execute(array('id' => $this->id));
    }
    
    public function validate_name(){
        $errors = array();
        $valid = $this->validate_string_length($this->name, 1);
        if($valid == false){
            $errors[] = 'Please fill out a name';
        }
        return $errors;
    }
    
    public function validate_description(){
        $errors = array();
        $valid = $this->validate_string_length($this->description, 10);
        if($valid == false){
            $errors[] = 'The description should be at least 10 characters long';
        }
        return $errors;
    }
    
    public function validate_extent(){
        $errors = array();
        $valid = $this->validate_number_size($this->extent, 0, 1000);
        if($valid == false){
            $errors[] = 'The extent of the degree is wrong (should be 0-1000)';
        }
        return $errors;
    }
    
    public function validate_city(){
        $errors = array();
        $valid = $this->validate_string_length($this->city, 1);
        if($valid == false){
            $errors[] = 'Please fill out a city';
        }
        return $errors;
    }
    
    public function validate_acceptancerate(){
        $errors = array();
        if($this->acceptancerate == null){
            return $errors;
        }
        
        $valid = $this->validate_number_size($this->acceptancerate, 0, 10);
        if($valid == false){
            $errors[] = 'Check the share of accepted applicants (should be 0-10)';
        }
        return $errors;
    }

    public function validate_institutions(){
        $errors = array();
        if(empty($this -> institutions)){
            $errors[] = 'Please select one or more institutions.!';
        }
        return $errors;
    }

}
