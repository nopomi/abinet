<?php

class Institution extends BaseModel {

    public $id, $name, $picture;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_name', 'validate_picture');
    }

    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Institution');
        $query->execute();
        $rows = $query->fetchAll();
        $institutions = array();

        foreach ($rows as $row) {
            $institutions[] = new Institution(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'picture' => $row['picture']
            ));
        }
        return $institutions;
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Institution SET name= :name, picture= :picture WHERE id = :id');
        $query->execute(array('id' => $this->id, 'name' => $this->name, 'picture' => $this->picture));
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Institution (name, picture) VALUES (:name, :picture) RETURNING id');
        $query->execute(array('name' => $this->name, 'picture' => $this->picture));
        $row = $query->fetch();
        $this->id = $row['id'];
    }
    
    public function delete() {
        $query = DB::connection()->prepare('DELETE FROM Institution WHERE id= :id');
        $query->execute(array('id' => $this->id));
    }

    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Institution WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $institution = new Institution(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'picture' => $row['picture']
            ));
            return $institution;
        }

        return null;
    }

    public function validate_name() {
        $errors = array();
        $valid = $this->validate_string_length($this->name, 3);
        if ($valid == false) {
            $errors[] = 'The name is too short, has to be at least 3 characters';
        }
        return $errors;
    }

    public function validate_picture() {
        $errors = array();
        $valid = $this->validate_string_length($this->picture, 10);
        if ($valid == false) {
            $errors[] = 'Please put in a link to a picture! You can host pictures on imgur.com.';
        }
        return $errors;
    }

}
