<?php

class Admin extends BaseModel {

    public $id, $email, $password;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function authenticate($email, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Admin WHERE email= :email AND password= :password LIMIT 1');
        $query->execute(array('email' => $email, 'password' => $password));
        $row = $query->fetch();
        if ($row) {
            $admin = new Admin(array(
                'email' => $row['email'],
                'id' => $row['id']
            ));
            return $admin;
        } else {
            return null;
        }
    }

}
