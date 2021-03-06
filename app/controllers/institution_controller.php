<?php

/*
 * Controller that handles CRUD functions of educational
 * institutions. Only accessible to admins.
 */

class InstitutionController extends BaseController {

    public static function index() {
        if(self::get_user_admin() == null) {
                Redirect::to('/home');
        }
        $institutions = Institution::all();
        View::make('admin/institutions.html', array('institutions' => $institutions));
    }

    public static function create() {
        if(self::get_user_admin() == null) {
                Redirect::to('/home');
        }
        View::make('/admin/institution.html');
    }

    public static function store() {
        if(self::get_user_admin() == null) {
                Redirect::to('/home');
        }

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
        if(self::get_user_admin() == null) {
                Redirect::to('/home');
        }
        $institution = Institution :: find($id);
        View::make('admin/edit_institution.html', array('institution' => $institution));
    }

    public static function update($id) {
        if(self::get_user_admin() == null) {
                Redirect::to('/home');
        }

        $params = $_POST;

        $institution = new Institution(array(
            'id' => $id,
            'name' => $params['name'],
            'picture' => $params['picture']
        ));
        
        
        $errors = $institution->errors();

        if (count($errors) == 0) {
            $institution->update();
            Redirect::to('/institutions', array('message' => 'Changes saved!'));
        } else {
            View::make('admin/edit_institution.html', array('errors' => $errors, 'institution' => $institution));
        }
    }

    public static function delete($id) {
        if(self::get_user_admin() == null) {
                Redirect::to('/home');
        }
        $degrees = Degree::findByInstitution($id);
        if(!empty($degrees)){
            Redirect::to('/institutions', array('error' => 'Institution could not be deleted, because it is linked to one or more degrees. First delete related degrees under Manage->Degrees.'));
        }
        $institution = Institution::find($id);
        $institution->delete();
        Redirect::to('/institutions', array('message' => 'Institution deleted!'));
    }

}
