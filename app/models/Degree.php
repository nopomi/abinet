<?php

class Degree extends BaseModel {

    public $id, $name, $deadline, $description,
            $accepted, $acceptancerate, $city, $extent;

    public function __construct($attributes) {
        parent::__construct($attributes);
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

}
