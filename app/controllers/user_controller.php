<?php

/*
 * Controller that handles admin and applicant related functions,
 * including login/logout and creation and deletion of accounts.
 */

class UserController extends BaseController{
    
  public static function login(){
      View::make('login.html');
  }
  
  public static function logout(){
      $_SESSION['user'] = null;
      $_SESSION['admin'] = null;
      Redirect::to('/home', array('message' => 'You have logged out!'));
  }
  
  public static function handle_login(){
    $params = $_POST;

    $user = Applicant::authenticate($params['email'], $params['password']);

    if(!$user){
      $admin = Admin::authenticate($params['email'], $params['password']);
      if(!$admin){
      View::make('login.html', array('error' => 'Oops! Username or password is wrong.', 'email' => $params['email']));
      } else {
          $_SESSION['user'] = $admin->id;
          $_SESSION['admin'] = true;
          Redirect::to('/home');
      }
    }else{
      $_SESSION['user'] = $user->id;
      $_SESSION['admin'] = false;
      Redirect::to('/mydegrees');
    }
  }
}

