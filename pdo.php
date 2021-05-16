<?php
   $pdo = new PDO('mysql:host=127.0.0.1;port=3308;dbname=tailor', 
      'kvp', "123");
   // See the "errors" folder for details...
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   $errors=array();
?>