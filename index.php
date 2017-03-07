<?php
error_reporting(E_ALL);
set_time_limit(10800);
date_default_timezone_set("Asia/Kolkata");
require_once("Autoloader.php");

 ## Object Initiated
 $purchaseOrderObj = new src\XmlClass\purchaseOrderXml();
 $purchaseOrderObj->generateXML();
 
 ##Object closed
 $purchaseOrderObj->close();
	
?>
