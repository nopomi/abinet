<?php
    
  class HelloWorldController extends BaseController{

    public static function index(){
      // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
   	  echo 'Tämä on etusivu!';
    }

    public static function sandbox(){
        
     $tech = new Degree(array(
         'name' => '',
         'description' => 'What a d',
         'extent' => -1,
         'city' => null,
         'acceptancerate' => 10.1
     ));
     
     $errors = $tech->errors();
        
     Kint::dump($errors);
    }
    
    public static function home(){
        View::make('home.html');
    }

    public static function degree(){
      View::make('suunnitelmat/degree.html');
    }

  }
