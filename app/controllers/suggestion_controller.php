<?php

/*
 * Controller that handles adding and deleting of suggestions.
 */

class SuggestionController extends BaseController {

	public static function index(){
		if(self::get_user_admin() == null) {
                Redirect::to('/home');
        }
		$allSuggestions = Suggestion::all();
		function cmp($a, $b){
			if($a->processed == $b->processed){
				if($a->id < $b->id){
					return -1;
				}
			} elseif($a->processed == 0){
				return -1;
			} else {
				return 1;
			}
		}
		usort($allSuggestions, "cmp");
		View::make('admin/suggestions.html', array('suggestions' => $allSuggestions));
	}

	public static function create(){
		View::make('suggestion.html');
	}

	public static function store(){
		$params = $_POST;

		$suggestion = new Suggestion(array(
			'creationtime' => null,
			'description' => $params['description'],
			'justification' => $params['justification'],
			'processed' => null
		));

		$errors = $suggestion->errors();

		if(count($errors) == 0){
			$suggestion->save();
			View::make('suggestion_confirmation.html');
		} else {
			View::make('suggestion.html', array('errors' => $errors, 'attributes' => $params));
		}

	}

	public static function delete($id){
		if(self::get_user_admin() == null) {
                Redirect::to('/home');
        }
		$suggestion = Suggestion::find($id);
		$suggestion->delete();
		Redirect::to('/suggestions', array('message' => 'Suggestion deleted!'));
	}

	public static function toggleProcessed($id){
		if(self::get_user_admin() == null) {
                Redirect::to('/home');
        }
		$suggestion = Suggestion::find($id);
		if(!$suggestion->processed){
			$suggestion->processed = 1;
		} else {
			$suggestion->processed = 0;
		}
		$suggestion->update();
		Redirect::to('/suggestions', array('message' => 'Updated!'));
	}


}
