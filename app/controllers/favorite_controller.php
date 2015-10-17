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

    publlic static function store($favoriteId){
    	$user = self::get_user_logged_in();
    	Favorite::
    }
}
