<?php
  require_once "obj.php" ;

  class wines extends obj {
    var $table = 'wines';
    var $defaults = [
      "id" ,
      "name" ,
      "grapes" ,
      "country" ,
      "region" ,
      "year" ,
      "description" ,
      "picture"
    ];

    var $idAttribute = "id" ;
    var $as = "wines" ;

  }
 ?>
