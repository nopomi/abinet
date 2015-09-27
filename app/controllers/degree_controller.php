<?php

class DegreeController extends BaseController {

    public static function index() {
        $degrees = Degree::all();
        View::make('admin/degrees.html', array('degrees' => $degrees));
    }

    public static function create() {
        View::make('/suunnitelmat/degree.html');
    }

    public static function store() {
        $params = $_POST;

        $degree = new Degree(array(
            'name' => $params['name'],
            'extent' => $params['extent'],
            'city' => $params['city'],
            'accepted' => $params['accepted'],
            'acceptancerate' => $params['acceptancerate'],
            'deadline' => $params['deadline'],
            'description' => $params['description']
        ));

        $errors = $degree->errors();

        if (count($errors) == 0) {
            $degree->save();

            Redirect::to('/degrees', array('message' => 'New degree added!'));
        } else {
            View::make('suunnitelmat/degree.html', array('errors' => $errors, 'attributes' => $params));
        }
    }

    public static function edit($id) {
        $degree = Degree :: find($id);
        View::make('edit.html', array('degree' => $degree));
    }

    public static function update($id) {

        $params = $_POST;

        $degree = new Degree(array(
            'id' => $id,
            'name' => $params['name'],
            'extent' => $params['extent'],
            'city' => $params['city'],
            'accepted' => $params['accepted'],
            'acceptancerate' => $params['acceptancerate'],
            'deadline' => $params['deadline'],
            'description' => $params['description']
        ));

        $errors = $degree->errors();

        if (count($errors) == 0) {
            $degree->update();
            Redirect::to('/degrees', array('message' => 'Changes saved!'));
        } else {
            View::make('edit.html', array('errors' => $errors, 'degree' => $degree));
        }
    }

    public static function delete($id) {
        $degree = Degree::find($id);
        $degree->delete();
        Redirect::to('/degrees', array('message' => 'Degree deleted!'));
    }

    public static function myDegrees() {
        $user = self::get_user_logged_in();
        if ($user) {
            $userid = $user->id;
            $favorites = Favorite::findByUser($userid);
            $degrees = array();
            foreach ($favorites as $favorite) {
                $degrees[] = Degree::find($favorite->degree_id);
            }
        }
        View::make('/suunnitelmat/mydegrees.html', array('degrees' => $degrees));
    }

}
