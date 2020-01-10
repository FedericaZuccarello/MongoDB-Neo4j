<?php 
require "Manipulation/importData.php";
require "Manipulation/recuperoIDMongo.php";
require "Manipulation/updateIDMongo.php";
require "Manipulation/appendConnection.php";
ini_set('max_execution_time', 999999999999999999);

importNameType();
importObjID();
aggregateObjID();
insertConnection();

 ?>