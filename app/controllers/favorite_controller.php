<?php

/*
 * Controller  that handles logging of user's favorite degrees
 * that are saved specifically to them.
 */

class FavoriteController extends BaseController {

    public static function delete($degree_id){
        $user = self::get_user_logged_in();
        Favorite::delete($user->id, $degree_id);
        Redirect::to('/mydegrees', array('message' => 'Favorite removed!'));
    }

    public static function store($favoriteId){
    	$user = self::get_user_logged_in();
    	if($user == null){
    		Redirect::to('/login');
    	}
    	$favorite = new Favorite(array(
    		'applicant_id' => $user->id,
    		'degree_id' => $favoriteId
    		));

    	$favorite->save();

    	Redirect::to('/search', array('message' => 'Degree saved to favorites!'));
    }
}
