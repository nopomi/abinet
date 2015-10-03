<?php

/*
 * Controller that handles CRUD functions of educational
 * institutions. Only accessible to admins.
 */

class InstitutionController extends BaseController {

    public static function index() {
        $institutions = Institution::all();
        View::make('admin/institutions.html', array('institutions' => $institutions));
    }

    public static function create() {
        View::make('/admin/institution.html');
    }

    public static function store() {
        $params = $_POST;

        $institution = new Institution(array(
            'name' => $params['name'],
            'picture' => $params['picture']
        ));

        $errors = $institution->errors();

        if (count($errors) == 0) {
            $institution->save();

            Redirect::to('/institutions', array('message' => 'New institution added!'));
        } else {
            View::make('admin/institution.html', array('errors' => $errors, 'attributes' => $params));
        }
    }

    public static function edit($id) {
        $institution = Institution :: find($id);
        View::make('admin/edit_institution.html', array('institution' => $institution));
    }

    public static function update($id) {

        $params = $_POST;

        $institution = new Institution(array(
            'id' => $id,
            'name' => $params['name'],
            'picture' => $params['picture']
        ));
        
        Kint::dump($institution);
        
        $errors = $institution->errors();

        if (count($errors) == 0) {
            $institution->update();
            Redirect::to('/institutions', array('message' => 'Changes saved!'));
        } else {
            View::make('admin/edit_institution.html', array('errors' => $errors, 'institution' => $institution));
        }
    }

    public static function delete($id) {
        $institution = Institution::find($id);
        $institution->delete();
        Redirect::to('/institutions', array('message' => 'Institution deleted!'));
    }

}
