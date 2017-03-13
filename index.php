<?php
error_reporting(E_ALL);
set_time_limit(10800);
date_default_timezone_set("Asia/Kolkata");
require_once("config/constant.php");
require_once("Autoloader.php");

 
 ##Object Initiated
 //$xml_850_Obj = new src\XmlClass\X12_850_Xml();
 //$xml_850_Obj->generateXML();
 
  $edi_850_Obj = new src\EdiClass\X12_850_Edi();
  
  //$edi_850_Obj->generatePurchaseOrderEDI('EDI_02032017.xml');
  
  //$edi_850_Obj->generatePurchaseOrderEDI('terenaam.xml');
  
  //$edi_850_Obj->generatePurchaseOrderEDI('EDI_850_1489127656.xml'); 
  
  //$edi_850_Obj->generatePurchaseOrderEDI('Ack_EDI_850_1489127656.xml');
  
  //$edi_850_Obj->generatePurchaseOrderEDI('Ack_EDI_850_1489127656.xml');


 ##Object closed
   $edi_850_Obj->close();
?>