<?php

class UserController extends BaseController{
    
  public static function login(){
      View::make('login.html');
  }
  
  public static function handle_login(){
    $params = $_POST;

    $user = Applicant::authenticate($params['email'], $params['password']);

    if(!$user){
      View::make('login.html', array('error' => 'Oops! Username or password is wrong.', 'email' => $params['email']));
    }else{
      $_SESSION['user'] = $user->id;
      Redirect::to('/mydegrees');
    }
  }
}

