<?php

/*
* Class that models improvement suggestions.
*/

class Suggestion extends BaseModel {

	public $id, $creationtime, $description, $justification, $processed;

	public function __construct($attributes) {
		parent::__construct($attributes);
		$this->validators = array('validate_description', 'validate_justification');
	}

	public static function all(){

		$query = DB::connection()->prepare('SELECT * FROM Suggestion');
		$query->execute();
		$rows = $query->fetchAll();

		$suggestions = array();

		foreach ($rows as $row) {
			$suggestions[] = new Suggestion(array(
				'id' => $row['id'],
				'creationtime' => $row['creationtime'],
				'description' => $row['description'],
				'justification' => $row['justification'],
				'processed' => $row['processed']
				));
		}

		return $suggestions;
	}

	public static function find($id){
		$query = DB::connection()->prepare('SELECT * FROM Suggestion WHERE id= :id LIMIT 1');
		$query->execute(array('id' => $id));
		$row = $query->fetch();

		if($row){
			$suggestion = new Suggestion(array(
				'id' => $row['id'],
				'creationtime' => $row['creationtime'],
				'description' => $row['description'],
				'justification' => $row['justification'],
				'processed' => $row['processed']
				));
			return $suggestion;
		}
		return null;
	}

	public function save(){
		$query = DB::connection()->prepare('INSERT INTO Suggestion (creationtime, description, justification) VALUES (LOCALTIMESTAMP(0), :description, :justification) RETURNING id');
		$query->execute(array('description' => $this->description, 'justification' => $this->justification));
		$row = $query->fetch();
		$this->id = $row['id'];
	}

	public function delete(){
		$query = DB::connection()->prepare('DELETE FROM Suggestion WHERE id= :id');
		$query->execute(array('id' => $this->id));
	}

	public function update(){
		$query = DB::connection()->prepare('UPDATE Suggestion SET description= :description, justification= :justification, processed= :processed WHERE id= :id');
		$query->execute(array('id' => $this->id, 'description' => $this->description, 'justification' => $this->justification, 'processed' => $this->processed));
	}

	public function validate_justification(){
		$errors = array();
		$valid = $this->validate_string_length($this->justification, 5);
		if($valid == false){
			$errors[] = 'Please fill out a short justification for the change.';
		}
		return $errors;
	}

	public function validate_description(){
		$errors = array();
		$valid = $this->validate_string_length($this->description, 20);
		if($valid == false){
			$errors[] = 'Please add a description of your suggestion (20+ characters).';
		}
		return $errors;
	}


}