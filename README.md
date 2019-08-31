# SIMPLE PHP REST API For Library Network
<img src="https://img.shields.io/badge/JSON-MARC21-orange?style=flat&logo=dev.to" alt="Marc21-Jason"> <img src="https://img.shields.io/badge/RESTfull-API-red?style=flat&logo=json" alt="RESTfull-API"> <img src="https://img.shields.io/badge/PHP-PDO-blue?style=flat&logo=php" alt="Php Pdo"> <img src="https://img.shields.io/github/license/mashape/apistatus.svg?style=flat" alt="License MIT"> <img src="https://img.shields.io/badge/VS-Code-blueviolet?style=flat&logo=visual-studio-code" alt="visual studio code">

> This is a simple PHP REST API For library network .

## Quick Start
###  Requirements
* PHP >= 7.2
* JSON PHP Extension
* PDO PHP Extension
* SQL SERVER PHP Extension
* XML PHP Extension

 ### Usage
  change the params in the config/Database.php file to your own
  Syngeb database Server 
 ```php
<?php 
  // DB Params
     private $host = 'server Adress';
     private $db_name = 'database';
     private $username = 'username';
     private $password = 'password';
 ```
 You can map your fields on api/book/read.php
 ```php
<?php 
 $book_item = array(
        'id' => $DOC_ID,
        'Cot_notice'=>$COT_NOTICE,
        'title' => $DOC_TITRE_PROPRE,
        'body' => $DOC_TITRE_COMPLEMENT,
        'author' => $DOC_TITRE_PARALLELE,
        'category_id' => $DOC_TITRE_ENSEMBLE,
        'YEAR' => $DOC_ANNEE,
        'ISBN' => $DOC_ISBN,
        'LAN_ID'=>$LAN_ID,
        'PAY_ID'=> $PAY_ID,
    ...
 ```
  

## App Info

### Author

Belaoura Abdelouahab
[Belaoura Abdelouahab](http://www.bplpadrar.dz)

### Version
1.0.0
### License
This project is licensed under the MIT License
