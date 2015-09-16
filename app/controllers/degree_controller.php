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

        $degree->save();

        Redirect::to('/degrees', array('message' => 'New degree added!'));
    }

    public static function modify($id) {
        $degree = Degree :: find($id);
        View::make('edit.html', array('degree' => $degree));
    }

}
