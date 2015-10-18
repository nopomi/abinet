    <?php

    /*
     * Controller that handles CRUD functions of all degrees. 
     */

    class DegreeController extends BaseController {

        public static function index() {
            $allInstitutions = Institution::all();
            $degrees = Degree::all();
            foreach ($degrees as $degree) {
                $institutions = $degree->institutions;
                $institutionList = "";
                foreach ($institutions as $institution) {
                    $institutionList = $institutionList . $institution->name;
                    $institutionList = $institutionList . "\n";
                }
                $degree->institutions = $institutionList;
            }
            View::make('admin/degrees.html', array('degrees' => $degrees));
        }

        public static function create() {
            $institutions = Institution::all();
            View::make('/admin/degree.html', array('institutions' => $institutions));
        }

        public static function store() {
            $params = $_POST;

            $degree = self::createDegree($params, $id);

            $errors = $degree->errors();

            if (count($errors) == 0) {
                $degree->save();
                $degree->saveInstitutions($params['institutions']);
                Redirect::to('/degrees', array('message' => 'New degree added!'));
            } else {
                $allInstitutions = Institution::all();
                if(isset($params['institutions'])){
                    $degree->institutions = $params['institutions'];
                }
                View::make('admin/degree.html', array('errors' => $errors, 'attributes' => $params, 'institutions' => $allInstitutions));
            }
        }

        public static function edit($id) {
            $degree = Degree :: find($id);
            $allInstitutions = Institution :: all();
            $institutionList = array();
            foreach ($degree->institutions as $institution) {
                $institutionList[] = $institution->id;
            }
            $degree->institutions = $institutionList;
            View::make('edit.html', array('degree' => $degree, 'institutions' => $allInstitutions));
        }

        public static function update($id) {

            $params = $_POST;

            $degree = self::createDegree($params, $id);

            $errors = $degree->errors();

            if (count($errors) == 0 && isset($params['institutions'])) {
                $degree->update();
                $degree->updateInstitutions($params['institutions']);
                Redirect::to('/degrees', array('message' => 'Changes saved!'));
            } else {
                $allInstitutions = Institution :: all();
                if(isset($params['institutions'])){
                    $degree->institutions = $params['institutions'];
                }
                View::make('edit.html', array('errors' => $errors, 'degree' => $degree, 'institutions' => $allInstitutions));
            }
        }   

        public static function delete($id) {
            $favorites = Favorite::findByDegree($id);
            foreach ($favorites as $favorite) {
                Favorite::delete($favorite->applicant_id, $favorite->degree_id);
            }

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
               foreach ($degrees as $degree) {
                $institutions = $degree->institutions;
                $institutionList = "";
                foreach ($institutions as $institution) {
                    $institutionList = $institutionList . $institution->name;
                    $institutionList = $institutionList . "\n";
                }
                $degree->institutions = $institutionList;
            }
           }
           View::make('mydegrees.html', array('degrees' => $degrees));
       }

       private static function createDegree($params, $id){

        $degree = new Degree(array(
                'id' => $id,
                'name' => $params['name'],
                'extent' => $params['extent'],
                'city' => $params['city'],
                'accepted' => $params['accepted'],
                'acceptancerate' => $params['acceptancerate'],
                'deadline' => $params['deadline'],
                'description' => $params['description'],
                'institutions' => null
                ));

            $institutions = array();
            if(isset($params['institutions'])){
                foreach ($params['institutions'] as $institutionId) {
                    $institutions[] = Institution::find($institutionId);
                }
            }
            $degree->institutions = $institutions;

            return $degree;
       }

   }
