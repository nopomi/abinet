<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;

    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }

    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();

      foreach($this->validators as $validator){
          $validator_errors = $this->{$validator}();
          $errors = array_merge($errors, $validator_errors);
      }

      return $errors;
    }
    
    public function validate_string_length($string, $length){
        if($string == null || strlen($string)<$length){
            return false;
        }
        return true;
    }
    
    public function validate_number_size($number, $min, $max){
        if($number == null || is_numeric($number) == false){
            return false;
        } elseif ($number < $min || $number > $max){
            return false;
        }
        return true;
    }
  }
