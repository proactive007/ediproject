<?php
error_reporting(E_ALL);
set_time_limit(10800);
date_default_timezone_set("Asia/Kolkata");
require_once('config/db.php');

class purchaseOrderXml extends dbConnection 
	{
		
        
		/**
		*  Start Tag : First Line Indicate Xml start syntax
		*  Second Line is for begin EDI Genration format 
		*  *:Element Seperator,~:Segment,/:Envelope Endor
		*/ 
		function startTag() 
			{
				$startText = '';
				$startText .= '<?xml version="1.0"?>'.PHP_EOL;
				$startText .= '<Interchange segment-terminator="~ &#xA;" element-separator="*" sub-element-separator="/">'.PHP_EOL;
				
				return $startText;
			}

		/**
		*  close Tag : close the (function header group and inerchange segment)
		*/ 	
	    function closeTag() 
		    {
		        $closeText = '';
		        $closeText .= '</FunctionGroup>'.PHP_EOL;
		    	$closeText .= '</Interchange>';
		    	return $closeText; 
		    }		

		
		/**
		*  interchangeControlHeader : Envelope Part or Header Of EDI 
		*  Total Tag 16 (ISA01 To ISA16 )
		*  *:Element Seperator,~:Segment,/:Envelope End
		*/    
		function interchangeControlHeader() 
			{
				$isaText = '';
				$isaText .= '<ISA>'.PHP_EOL;
				
				#Author Information Qualifier (TYPE=ID MIN=2 MAX=2)
    			$isaText .= '<ISA01>00</ISA01>'.PHP_EOL;
			    #Author Information (TYPE=AN MIN=10 MAX=10)
			    $isaText .= '<ISA02>          </ISA02>'.PHP_EOL;
           	    
				#Security Information Qualifer (TYPE=ID MIN=2 MAX=2) 
		    	$isaText .= '<ISA03>00</ISA03>'.PHP_EOL;
		        #Security Information (TYPE=AN MIN=10 MAX=10)
		        $isaText .= '<ISA04>          </ISA04>'.PHP_EOL;
    			
				#Interchange ID Qualifier (TYPE=ID MIN=2 MAX=2)
			    $isaText .= '<ISA05>ZZ</ISA05>'.PHP_EOL;
			    #Interchange Sender ID (TYPE=AN MIN=15 MAX=15)
			    $isaText .= '<ISA06>999TEST        </ISA06>'.PHP_EOL;
			    
				#Interchange ID Qualifier (TYPE=ID MIN=2 MAX=2) 
			    $isaText .= '<ISA07>ZZ</ISA07>'.PHP_EOL;
			    #Interchange Receiver ID (TYPE=AN MIN=15 MAX=15)
			    $isaText .= '<ISA08>ORGILL         </ISA08>'.PHP_EOL;
			    
				#Interchange Date (TYPE=DT MIN=6 MAX=6)
			    $isaText .= '<ISA09>121101</ISA09>'.PHP_EOL;
			    #Interchange Time (TYPE=TM MIN=4 MAX=4)
			    $isaText .= '<ISA10>1315</ISA10>'.PHP_EOL;
			    
				#Inter Control Standards Identifier (TYPE=ID MIN=1 MAX=1) 
			    $isaText .= '<ISA11>U</ISA11>'.PHP_EOL;
			    #Inter Control Version Number (TYPE=ID MIN=5 MAX=5)
			    $isaText .= '<ISA12>00401</ISA12>'.PHP_EOL;
			    
				#Inter Control Number (TYPE=N0 MIN=9 MAX=9)
			    $isaText .= '<ISA13>000001208</ISA13>'.PHP_EOL;
			    
				#Acknowlegment Requested (TYPE=ID MIN=1 MAX=1)
			    $isaText .= '<ISA14>0</ISA14>'.PHP_EOL;
			    
				#Usage Indicator (TYPE=ID MIN=1 MAX=1)
			    $isaText .= '<ISA15>P</ISA15>'.PHP_EOL;
			    
				#Component Element Separator (TYPE= MIN=1 MAX=1) 
			    $isaText .= '<ISA16> 
			                 <ISA1601 />
			                 <ISA1602 />'.PHP_EOL;
    			$isaText .= '</ISA16>'.PHP_EOL;
    			$isaText .= '</ISA>'.PHP_EOL;

    			$isaText .= '<FunctionGroup>'.PHP_EOL;

    			return $isaText;
			}

		/**
		*  gsSegment : Strat Funcxtional Group Header
		*  Total Tag 8 (GS01 To GS08 )
		*  *:Element Seperator,~:Segment
		*/		
	   function gsSegment() 
		    {
		    	$gsText = '';
		    	$gsText .= '<GS>'.PHP_EOL;
			    
				#Functional Identifier Code (TYPE=ID MIN=2 MAX=2)
			    $gsText .= '<GS01>PO</GS01>'.PHP_EOL;
		      	
				#Application Sender's Code (TYPE=AN MIN=2 MAX=15) (Same as ISA06)
		      	$gsText .= '<GS02>999TEST</GS02>'.PHP_EOL;
			    #Application Receiver's Code (TYPE=AN MIN=2 MAX=15) (Same as ISA08)
			    $gsText .= '<GS03>ORGILL</GS03>'.PHP_EOL;
			    
				#Date (TYPE=AN MIN=8 MAX=8)
			    $gsText .= '<GS04>20121101</GS04>'.PHP_EOL;
			    #Time 
			    $gsText .= '<GS05>1315</GS05>'.PHP_EOL;

			    #Group Control Number (TYPE=N0 MIN=1 MAX=9)
			    $gsText .= '<GS06>1208</GS06>'.PHP_EOL;
			    #Responsible Agency Code (TYPE=ID MIN=1 MAX=2)
			    $gsText .= '<GS07>X</GS07>'.PHP_EOL;
			    
				#Version/Release/Industry Identifier Code (TYPE=AN MIN=1 MAX=12)
			    $gsText .= '<GS08>004010</GS08>'.PHP_EOL;
    			$gsText .= '</GS>'.PHP_EOL;
    			return $gsText;
		    } 

		/**
		*  transactionSegment : Strat Transaction ControlNumber
		*  *:Element Seperator,~:Segment
		*/		    
	   function transactionSegment() 
		   {
		   		$tsText = '';
                
                $tsText .= '<Transaction ControlNumber="657977">'.PHP_EOL;
      			
      			/* Start Transaction Set Header */
      			$tsText .='<ST>'.PHP_EOL;
		        #Transaction Set Identifier Code
		        $tsText .='<ST01>850</ST01>'.PHP_EOL;
                #Transaction Set Control Number
                $tsText .='<ST02>657977</ST02>'.PHP_EOL;
                $tsText .='</ST>'.PHP_EOL;
		      
		        /* Start Beginning Segment for Purchase Order */
		        $tsText .='<BEG>'.PHP_EOL;
		        $tsText .='<BEG01>00</BEG01>'.PHP_EOL;
		        $tsText .='<BEG02>DS</BEG02>'.PHP_EOL;
		        $tsText .='<BEG03>20121101-60929</BEG03>'.PHP_EOL;
		        $tsText .='<BEG04 />'.PHP_EOL;
		        $tsText .='<BEG05>20121101</BEG05>'.PHP_EOL;
		        $tsText .='</BEG>'.PHP_EOL;
      
      			/* Start REF Reference Identification */
      			$tsText .='<REF>'.PHP_EOL;
		        #Reference Identification Qualifier
		        $tsText .='<REF01>PD</REF01>'.PHP_EOL;
		        #Reference Identification
		        $tsText .='<REF02>PD</REF02>'.PHP_EOL;
      			$tsText .='</REF>'.PHP_EOL;

      			/* Strat OF FOB F.O.B. Related Instructions */
				$tsText .='<FOB>'.PHP_EOL;
				$tsText .='<FOB01>DE</FOB01>'.PHP_EOL;
				$tsText .='<FOB02 />'.PHP_EOL;
				$tsText .='<FOB03 />'.PHP_EOL;
				$tsText .='<FOB04 />'.PHP_EOL;
				$tsText .='<FOB05>FOB</FOB05>'.PHP_EOL;
				$tsText .='<FOB06>AP</FOB06>'.PHP_EOL;
				$tsText .='</FOB>'.PHP_EOL;
				
				/* Terms of Sale/Deferred Terms of Sale */
				$tsText .='<ITD>'.PHP_EOL;
				$tsText .='<ITD01>ZZ</ITD01>'.PHP_EOL;
				$tsText .='</ITD>'.PHP_EOL;
				
				/* Start Code For DTM Date/Time Reference */
				$tsText .='<DTM>'.PHP_EOL;
				#Data/Time Qualifier
				$tsText .='<DTM01>036</DTM01>'.PHP_EOL;
				#Date
				$tsText .='<DTM02>20121101</DTM02>'.PHP_EOL;
				$tsText .='</DTM>'.PHP_EOL;
				
				/* Start Code For TD5 Carrier Details */
				$tsText .='<TD5>'.PHP_EOL;
				$tsText .='<TD501 />'.PHP_EOL;
				$tsText .='<TD502>2</TD502>'.PHP_EOL;
				$tsText .='<TD503>UPSS</TD503>'.PHP_EOL;
				$tsText .='<TD504 />'.PHP_EOL;
				$tsText .='<TD505 />'.PHP_EOL;
				$tsText .='<TD506 />'.PHP_EOL;
				$tsText .='<TD507 />'.PHP_EOL;
				$tsText .='<TD508 />'.PHP_EOL;
				$tsText .='<TD509 />'.PHP_EOL;
				$tsText .='<TD510 />'.PHP_EOL;
				$tsText .='<TD511 />'.PHP_EOL;
				$tsText .='<TD512>3D</TD512>'.PHP_EOL;
				$tsText .='</TD5>'.PHP_EOL;

      			$tsText .='<Loop LoopId="N1" Name="Name">'.PHP_EOL;
				
				/* N1 Name */
				$tsText .='<N1>'.PHP_EOL;
				#Entity Identifier Code
				$tsText .='<N101>ST</N101>'.PHP_EOL;
				#Name
				$tsText .='<N102>Jim Duhamel</N102>'.PHP_EOL;
				#Identification Code Qualifier
				$tsText .='<N103>92</N103>'.PHP_EOL;
				#Identification Code
				$tsText .='<N104>004</N104>'.PHP_EOL;
				$tsText .='</N1>'.PHP_EOL;
        		
        		/* N3 Address Information */
        		$tsText .='<N3>'.PHP_EOL;
		        #Address Information
		        $tsText .='<N301>176 South St (EMC)</N301>'.PHP_EOL;
		        #Address Information
		        $tsText .='<N302>A1-O749</N302>'.PHP_EOL;
        		$tsText .='</N3>'.PHP_EOL;
				
				/* Geographic Location */
				$tsText .='<N4>'.PHP_EOL;
				#City Name
				$tsText .='<N401>ANY CITY</N401>'.PHP_EOL;
				#State or Provice Code
				$tsText .='<N402>MA</N402>'.PHP_EOL;
				#Postal Code
				$tsText .='<N403>11748-1130</N403>'.PHP_EOL;
				#Country Code
				$tsText .='<N404>US</N404>'.PHP_EOL;
				$tsText .='</N4>'.PHP_EOL;

      			$tsText .='</Loop>'.PHP_EOL;

				$tsText .='<Loop LoopId="PO1" Name="Baseline Item Data">'.PHP_EOL;
				
				/* Baseline Item Data . */
				$tsText .='<PO1>'.PHP_EOL;
				$tsText .='<PO101 />'.PHP_EOL;
				$tsText .='<PO102>1</PO102>'.PHP_EOL;
				$tsText .='<PO103>EA</PO103>'.PHP_EOL;
				$tsText .='<PO104>0</PO104>'.PHP_EOL;
				$tsText .='<PO105 />'.PHP_EOL;
				$tsText .='<PO106>VP</PO106>'.PHP_EOL;
				$tsText .='<PO107>6350268</PO107>'.PHP_EOL;
				$tsText .='<PO108>BP</PO108>'.PHP_EOL;
				$tsText .='<PO109>856071649243042</PO109>'.PHP_EOL;
				$tsText .='</PO1>';
				
				/*IT8 Conditions of Sale */
				$tsText .='<IT8>'.PHP_EOL;
				$tsText .='<IT801 />';
				$tsText .='<IT802>B0</IT802>'.PHP_EOL;
				$tsText .='</IT8>'.PHP_EOL;
				$tsText .='</Loop>'.PHP_EOL;
                
                /* Transaction Set Trailer */
                $tsText .='<SE>'.PHP_EOL;
		        #Number of Included Segments
		        $tsText .='<SE01>13</SE01>'.PHP_EOL;
		        #Transaction Set Control Number
		        $tsText .='<SE02>657977</SE02>'.PHP_EOL;
		        $tsText .='</SE>'.PHP_EOL;
                $tsText .='</Transaction>'.PHP_EOL;
               
                return $tsText;
		   }
       
       /* Functional Group Trailer */
	   function geSegment() 
		   {
		   	 $geText = '';
		   	 $geText .= '<GE>'.PHP_EOL;
		   	 #Number of Transaction Sets Included
		   	 $geText .= '<GE01>7</GE01>'.PHP_EOL;
		   	 #Group Control Number
		   	 $geText .= '<GE02>1208</GE02>'.PHP_EOL;
		   	 $geText .= '</GE>'.PHP_EOL;
		   	 return $geText;
		   }

	   /*  Interchange Control Trailer */	   
       function ieaSegment() 
	       {
			$ieaText = '';	
			$ieaText .='<IEA>'.PHP_EOL;
			# Number of Included Functional Groups
			$ieaText .='<IEA01>1</IEA01>'.PHP_EOL;
			# Interchange Control Number
			$ieaText .='<IEA02>000001208</IEA02>'.PHP_EOL;
			$ieaText .='</IEA>'.PHP_EOL;
			return $ieaText;
  	       }


	   /* Start Code For Generate 850 XML */
	   function generateXML() 
		   {
		   		$conn = $this->connect();
		   		$startTag = $this->startTag();
		   		$interchangeControlHeader = $this->interchangeControlHeader();
		   		$gsSegment = $this->gsSegment();
		   		$transactionSegment = $this->transactionSegment();
		   		$geSegment = $this->geSegment();
		   		$ieaSegment = $this->ieaSegment();
		   		$closeTag = $this->closeTag();

		   		$xmlText = $startTag.$interchangeControlHeader.$gsSegment.$transactionSegment.$geSegment.$ieaSegment.$closeTag;
                
                $dir = "XML/EDI_".date('dmY');
		 	 	$filename = $dir.".xml";
		 	 	$myFile = $filename;
				$fh = fopen($myFile, 'w') or die("can't open file");

				fwrite($fh, $xmlText);
                fclose($fh);
		   }			
	}

 ## Object Initiated
 $purchaseOrderObj = new purchaseOrderXml();
 $purchaseOrderObj->generateXML();
 
 ##Object closed
 $purchaseOrderObj->close();
	
?>