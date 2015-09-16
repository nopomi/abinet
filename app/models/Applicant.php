<?php

class Applicant extends BaseModel {

    public $id, $email, $password;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Applicant');
        $query->execute();
        $rows = $query->fetchAll();
        $applicants = array();

        foreach ($rows as $row) {
            $applicants[] = new Applicant(array(
                'id' => $row['id'],
                'email' => $row['email'],
                'password' => $row['password']
            ));
        }
        return $applicants;
    }
    
    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM Applicant WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row){
            $applicant = new Applicant(array(
                'id' => $row['id'],
                'email' => $row['email'],
                'password' => $row['password']
                ));
            return $applicant;
        }
        
        return null;
    }

}
