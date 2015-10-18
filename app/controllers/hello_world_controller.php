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
      $degrees = Degree::all();
      $degree1 = $degrees['0'];
      $degree2 = $degrees['1'];
      $degree3 = $degrees['2'];
      $degree1->institution = $degree1->institutions['0'];
      $degree2->institution = $degree2->institutions['0'];
      $degree3->institution = $degree3->institutions['0'];
        View::make('home.html', array('degree1' => $degree1, 'degree2'=>$degree2, 'degree3'=>$degree3));
    }

    public static function degree(){
      View::make('suunnitelmat/degree.html');
    }

  }
