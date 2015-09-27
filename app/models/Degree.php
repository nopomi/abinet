<?php

class Degree extends BaseModel {

    public $id, $name, $deadline, $description,
            $accepted, $acceptancerate, $city, $extent;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_description', 'validate_city', 'validate_extent',
            'validate_acceptancerate');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Degree');
        $query->execute();
        $rows = $query->fetchAll();
        $degrees = array();

        foreach ($rows as $row) {
            $degrees[] = new Degree(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'deadline' => $row['deadline'],
                'description' => $row['description'],
                'accepted' => $row['accepted'],
                'acceptancerate' => $row['acceptancerate'],
                'city' => $row['city'],
                'extent' => $row['extent']
            ));
        }
        return $degrees;
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Degree WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $degree = new Degree(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'deadline' => $row['deadline'],
                'description' => $row['description'],
                'accepted' => $row['accepted'],
                'acceptancerate' => $row['acceptancerate'],
                'city' => $row['city'],
                'extent' => $row['extent']
            ));
            return $degree;
        }

        return null;
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Degree (name, description, deadline, accepted, acceptancerate, city, extent) VALUES (:name, :description, :deadline, :accepted, :acceptancerate, :city, :extent) RETURNING id');
        $query->execute(array('name' => $this->name, 'description' => $this->description, 'deadline' => $this->deadline, 'accepted'=>$this->accepted, 'acceptancerate' => $this->acceptancerate, 'city' => $this->city, 'extent' => $this->extent));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function update() {
        $query = DB::connection()->prepare('UPDATE Degree SET name= :name, description= :description, deadline= :deadline, accepted= :accepted, acceptancerate= :acceptancerate, city= :city, extent= :extent WHERE id = :id');
        $query->execute(array('id' => $this->id, 'name' => $this->name, 'description' => $this->description, 'deadline' => $this->deadline, 'accepted'=>$this->accepted, 'acceptancerate' => $this->acceptancerate, 'city' => $this->city, 'extent' => $this->extent));
    }
    
    public function delete() {
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

}
