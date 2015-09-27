<?php

  class BaseController{

    public static function get_user_logged_in(){
    if(isset($_SESSION['user'])){
      $user_id = $_SESSION['user'];
      $user = Applicant::find($user_id);

      return $user;
    }

    return null;
  }

  }
