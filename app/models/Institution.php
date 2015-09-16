<?php


class Institution extends BaseModel{
    public $id, $name, $picture;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
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
    
    public static function find($id){
        $query = DB::connection()->prepare('SELECT * FROM Institutions WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();
        
        if($row){
            $institution = new Institution(array(
                'id' => $row['id'],
                'name' => $row['name'],
                'picture' => $row['picture']
                ));
            return $institution;
        }
        
        return null;
    }
    
    public static function findByDegree($degreeId){
        $query = DB::connection()->prepare('SELECT * FROM Degree_Institution WHERE degree_id = :degreeId');
        $query->execute(array('degreeId' => $degreeId));
        $rows = $query -> fetch();
        $institutions = array();
        
        foreach ($rows as $row){
            $institutions[] = self::find($row['institution_id']);
        }
        return $institutions;
}
}