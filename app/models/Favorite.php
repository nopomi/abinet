<?php

/*
 * Model of user-specific favorite degrees. Handles validation of parameters,
 * creation, deletion and database queries.
 */


class Favorite extends BaseModel {

    public $applicant_id, $degree_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function findByUser($id) {
        $query = DB::connection()->prepare('SELECT * FROM Favorite WHERE applicant_id = :id');
        $query->execute(array('id' => $id));
        $rows = $query->fetchAll();

        $favorites = array();
        foreach ($rows as $row) {
            $favorites[] = new Favorite(array(
                'applicant_id' => $row['applicant_id'],
                'degree_id' => $row['degree_id']
            ));
        }

        return $favorites;
    }

    public function delete($applicant_id, $degree_id) {
        $query = DB::connection()->prepare('DELETE FROM Favorite WHERE applicant_id= :applicant_id AND degree_id= :degree_id');
        $query->execute(array('applicant_id' => $applicant_id, 'degree_id' => $degree_id));
    }

}
