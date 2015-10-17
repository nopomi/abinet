    <?php

    /*
     * Controller that handles searching for degrees. 
     */

    class SearchController extends BaseController {

    	public function index(){
    		$institutions = Institution::all();
    		View::make('search.html', array('institutions' => $institutions));
    	}

    	public function search(){
    		$params = $_POST;
    		$keyword = $params['keyword'];
    		$city = $params['city'];
    		$institutions = $params['institutions'];
    		$accepted_max = $params['accepted_max'];
    		$accepted_min = $params['accepted_min'];
    		$extent_max = $params['extent_max'];
    		$extent_min = $params['extent_min'];

    		if(!is_numeric($accepted_max) || !is_numeric($accepted_min)
    			|| !is_numeric($extent_min) || !is_numeric($extent_max)){
    			View::make('search.html', array('error' => 'Some search parameters were weird, try again!'));
    		}

    	$degrees = Degree::search($city, $accepted_max, $accepted_min, $extent_max, $extent_min);

    	$institutionCorrectDegrees = array();

    	foreach ($degrees as $degree) {
    		foreach ($degree->institutions as $degreeInstitution) {
    			if(in_array($degreeInstitution->id, $institutions)){
    				$institutionCorrectDegrees[] = $degree;
    				break;
    			}
    		}
    	}



    	foreach ($degrees as $degree) {
    		$institutions = $degree->institutions;
    		$institutionList = "";
    		foreach ($institutions as $institution) {
    			$institutionList = $institutionList . $institution->name . "\n";
    		}
    		$degree->institutions = $institutionList;
    	}

    	$allInstitutions = Institution::all();

    	View::make('search.html', array('institutions' => $allInstitutions, 'degrees' => $degrees));
    }

}