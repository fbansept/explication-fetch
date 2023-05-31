 <?php
 $bdd = new PDO(
        'mysql:host=localhost;dbname=explication-fetch', 
        'root', 
        '', 
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, 
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ));