<?php
   try {
   
    $VGconexion = new PDO('mysql:host=localhost;dbname=reservas;charset=utf8', 'root', '');
    $VGconexion -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $VGconexion -> query("SET NAMES 'utf8';");

  }
  catch(PDOException $er) {
      echo 'Error conectando a la BD. '.$er->getMessage(); 
  }
?>