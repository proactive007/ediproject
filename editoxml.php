<?php
require_once("config/constant.php");
//$filePath = "EDI_02032017.edi";
//$filePath = "EDI_850_1489127656.edi";
//$filePath = "EDI/terenaam.edi";
$filePath = "Ack_EDI_850_1489127656.edi";
generateEdiToXml($filePath,"EDI");

function generateEdiToXml($filename,$folderName) 
  {
      $ediFileName = $folderName."/".$filename;
      if(!file_exists($ediFileName)) 
        { 
          //## Maintain Log File;
          die("File Not Found");
        }

       ## Set XML Acknoldgment File full path and filename of the file to be output.
        $xmlfileName = explode(".",$filename);
        $xml_File_Name = "Ack_".$xmlfileName[0].".xml";
        $XmlFile = XML_FILE_PATH."Acknowledgment/".$xml_File_Name;
        $X12__Ack__XmlFile = fopen($XmlFile,'w');   

        $lt = chr(60);
        $gt = chr(62);
        $i = 0;
        $j = 0;
        $indent = 0;

        $fp   = @file_get_contents($ediFileName);
        $segments      = explode("~",$fp);
        $segment_lenth = sizeof($segments);
        fprintf($X12__Ack__XmlFile,"%s?xml version=\"1.0\" encoding=\"UTF-8\" ?%s\n",$lt,$gt);
        fprintf($X12__Ack__XmlFile,'<Interchange segment-terminator="~ &#xA;" element-separator="*" sub-element-separator="/">'.PHP_EOL); 

        

        for($i=0; $i<$segment_lenth-1; $i++)
          {
              $elements      = explode("*",$segments[$i]);
              $element_lenth = sizeof($elements);
              $record_type   = strtoupper(trim($elements[0],"\r\n\t\0"));
             
              if(empty($record_type))
                {
                  break;
                }
        
              if(trim($record_type)=="GS") {
                fprintf($X12__Ack__XmlFile,"<FunctionGroup>".PHP_EOL);
              } else if(trim($record_type)=="IEA") {
                fprintf($X12__Ack__XmlFile,"</FunctionGroup>".PHP_EOL);
              } 

              if(trim($record_type)=="ST") {
                fprintf($X12__Ack__XmlFile,"<Transaction ControlNumber='".$elements[2]."'>".PHP_EOL);
              } 

              fprintf($X12__Ack__XmlFile,"%s<%s>\n", str_repeat(" ",$indent),trim($record_type)); 

              for($j=1; $j<$element_lenth; $j++)
                {
                   $dataVal = str_replace(' ', '@', $elements[$j]);
                   
                  if($j<10) 
                    {
                     fprintf($X12__Ack__XmlFile,"%s<%s0%s>%s</%s0%s>\n",str_repeat(" ",($indent+2)),trim($record_type),$j,htmlspecialchars(trim($dataVal)),trim($record_type),$j); 
                    } 
                  else 
                    {
                      fprintf($X12__Ack__XmlFile,"%s<%s%s>%s</%s%s>\n",str_repeat(" ",($indent+2)),trim($record_type),$j,htmlspecialchars(trim($dataVal)),trim($record_type),$j);
                    } 
                }

              fprintf($X12__Ack__XmlFile,"%s</%s>\n",str_repeat("",$indent),trim($record_type));
              if(trim($record_type)=="SE") {
                fprintf($X12__Ack__XmlFile,"</Transaction>".PHP_EOL);
              }

          }
          fprintf($X12__Ack__XmlFile,"</Interchange>");

  } 
?>
