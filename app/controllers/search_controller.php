    <?php

    /*
     * Controller that handles searching for degrees. 
     */

    class SearchController extends BaseController {

    	public function index(){
    		$institutions = Institution::all();
    		$degrees = Degree::all();
            self::makeInstitutionsStrings($degrees);
            $favorites = FavoriteController::getUserFavorites();
    		View::make('search.html', array('degrees' => $degrees, 'institutions' => $institutions, 'favorites' => $favorites));
    	}

    	public function search(){

            // Pick up parameters
    		$params = $_POST;
    		$keyword = $params['keyword'];
    		$city = $params['city'];
    		$institutions = $params['institutions'];
    		$accepted_max = $params['accepted_max'];
    		$accepted_min = $params['accepted_min'];
    		$extent_max = $params['extent_max'];
    		$extent_min = $params['extent_min'];

            //check number values are valid
    		if(!is_numeric($accepted_max) || !is_numeric($accepted_min)
    			|| !is_numeric($extent_min) || !is_numeric($extent_max)){
    			View::make('search.html', array('error' => 'Some search parameters were weird, try again!'));
    	   }

           //Convert percentages to decimal
           $accepted_max = $accepted_max / 100;
           $accepted_min = $accepted_min / 100;

           //Find degrees that match the city and numeric parameters
    	   $degrees = Degree::search($city, $accepted_max, $accepted_min, $extent_max, $extent_min);

    	   $institutionCorrectDegrees = array();

            //filter the results that contain correct institution
    	   foreach ($degrees as $degree) {
    		  foreach ($degree->institutions as $degreeInstitution) {
    			if(in_array($degreeInstitution->id, $institutions)){
    				$institutionCorrectDegrees[] = $degree;
    				break;
    			 }
    		  }
    	   }


            //filter the results that match the keyword
    	   $keywordMatchingDegrees = array();
    	   if(strlen($keyword)>0){
            $keywordMatchingDegrees = $this->filterByKeyword($institutionCorrectDegrees, $keyword);
    	   } else {
    		$keywordMatchingDegrees = $institutionCorrectDegrees;
    	   }

            self::makeInstitutionsStrings($keywordMatchingDegrees);

            $allInstitutions = Institution::all();

            //add favorites
            $favorites = FavoriteController::getUserFavorites();

            //return view
            if(empty($keywordMatchingDegrees)){
                $error = 'No results were found, sorry!';
                View::make('search.html', array('institutions' => $allInstitutions, 'error' => $error, 'degrees' => $keywordMatchingDegrees));
            }

    	   View::make('search.html', array('institutions' => $allInstitutions, 'degrees' => $keywordMatchingDegrees, 'favorites' => $favorites));
        }

        private function makeInstitutionsStrings($degrees){

            foreach ($degrees as $degree) {
                $institutions = $degree->institutions;
                $institutionList = "";
                foreach ($institutions as $institution) {
                    $institutionList = $institutionList . $institution->name . "\n";
                }
                $degree->institutions = $institutionList;
            }

        }

        private function filterByKeyword($degrees, $keyword){
            $resultDegrees = array();
            foreach ($degrees as $degree) {
                if(strpos($degree->name, $keyword) !== false || strpos($degree->description, $keyword) !== false){
                    $resultDegrees[] = $degree;
                    continue;
                }
                foreach ($degree->institutions as $institution) {
                    if(strpos($institution->name, $keyword) !== false){
                        $resultDegrees[] = $degree;
                        break;
                    }
                }
              }
            return $resultDegrees;
        }

}