<?php
    
  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  echo 'Tämä on etusivu!';
    }

    public static function sandbox(){
     $applicant = Applicant::find(1);
     $degrees = Degree::all();
     
     Kint::dump($applicant);
     Kint::dump($degrees);
    }
    
    public static function home(){
        View::make('home.html');
    }

    public static function mydegrees(){
      View::make('suunnitelmat/mydegrees.html');
    }

    public static function degree(){
      View::make('suunnitelmat/degree.html');
    }

  }
