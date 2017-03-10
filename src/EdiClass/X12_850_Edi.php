<?php
namespace src\EdiClass;
use config\db as connection;

class X12_850_Edi extends connection 
	{
	   
	   public function __construct() 
		   {
		   	 $conn = $this->connect();
		   }	
       
	  /** 
	   * EDI: Generate Purchase Order EDI
       * @author : Ravinesh
       * NOTE: Valid Filename are REQUIRED
       * Date : 10:03:2017
       **/   
       public function generatePurchaseOrderEDI($filename) 
	       {
	       		$fileRec = explode('.',$filename);
	       		
	       		$EDI_File_Name  = $fileRec[0].".edi"; 
	       		
	       		$edi850Array = $this->generateXmlToArray($filename);
                
				##If File Not Found Generate Error Log 
                if(empty($edi850Array)) 
	                {
	                	die("XML File Is Not Found!");	
	                }

	            ## Set EDI Filename to the full path and filename of the file to be output.
				$X12850File = EDI_FILE_PATH.$EDI_File_Name;
				$X12__850__File = fopen($X12850File,'w');
				    

				## Define Segment Terminator(~)
	       		$segmentTerminator = $edi850Array["@attributes"]["segment-terminator"];
	       		## Define Element Seperator(*)
	       		$elementSeparator = $edi850Array["@attributes"]["element-separator"];
	      		## Define Sub Element Separator (/)
	       		$subElementSeparator = $edi850Array["@attributes"]["sub-element-separator"];
	       		
	       	    ## Define Interchange Control Header Array
                $ISA_Array = $edi850Array["ISA"];

				## Define Functional Group Header Array 
                $GS_Array = $edi850Array["FunctionGroup"]["GS"];

                ## Define Transaction Array 
                $Transaction_Array = $edi850Array["FunctionGroup"]["Transaction"]; 

                

                ## Define Functional Group Trailer Array 
                $GE_Array = $edi850Array["FunctionGroup"]["GE"];

                ## Define Interchange Control Traile Array 
                $IEA_Array = $edi850Array["IEA"];

                $this->isaSegmentEDI($ISA_Array,$X12__850__File,$segmentTerminator,$elementSeparator,$subElementSeparator);
                $this->gsSegmentEDI($GS_Array,$X12__850__File,$segmentTerminator,$elementSeparator);

                $this->transactionSegmentEDI($Transaction_Array,$X12__850__File,$segmentTerminator,$elementSeparator);

                $this->geSegmentEDI($GE_Array,$X12__850__File,$segmentTerminator,$elementSeparator);
				
				$this->ieaSegmentEDI($IEA_Array,$X12__850__File,$segmentTerminator,$elementSeparator);
                fclose($X12__850__File);
           }


	   /** 
	   * ISA - INTERCHANGE CONTROL HEADER
       * @author : Ravinesh
       * NOTE: All elements of the ISA are REQUIRED
       * Date : 10:03:2017
       **/
	   public function isaSegmentEDI($recArray,$X12__850__File,$segmentTerminator,$elementSeparator,$subEleSep) 
		   {    
		   	    
		   		$ISA01__AuthorInfoQual = str_replace('@',' ',$recArray["ISA01"]);
				$ISA02__AuthorInformation = str_replace('@',' ',$recArray["ISA02"]);
				$ISA03__SecurityInfoQual = str_replace('@',' ',$recArray["ISA03"]);
				$ISA04__SecurityInformation = str_replace('@',' ',$recArray["ISA04"]);
				$ISA05__InterchangeIDQual = str_replace('@',' ',$recArray["ISA05"]);
				$ISA06__InterchangeSenderID = str_replace('@',' ',$recArray["ISA06"]);
				$ISA07__InterchangeIDQual = str_replace('@',' ',$recArray["ISA07"]);
				$ISA08__InterchangeReceiverID= str_replace('@',' ',$recArray["ISA08"]);
				$ISA09__InterchangeDate = str_replace('@',' ',$recArray["ISA09"]);
				$ISA10__InterchangeTime = str_replace('@',' ',$recArray["ISA10"]);
				$ISA11__InterchangeControlStandardIden = str_replace('@',' ',$recArray["ISA11"]);
				$ISA12__InterchangeControlVersionNum = str_replace('@',' ',$recArray["ISA12"]);
				$ISA13__InterchangeControlNumber = str_replace('@',' ',$recArray["ISA13"]);
				$ISA14__AckRequested = str_replace('@',' ',$recArray["ISA14"]);
				$ISA15__UsageIndicator = str_replace('@',' ',$recArray["ISA15"]);				
				$ISA16__ComponentElementSeperator = "/";

				fwrite($X12__850__File, "ISA".$elementSeparator
						.$ISA01__AuthorInfoQual.$elementSeparator
						.$ISA02__AuthorInformation.$elementSeparator
						.$ISA03__SecurityInfoQual.$elementSeparator
						.$ISA04__SecurityInformation.$elementSeparator
						.$ISA05__InterchangeIDQual.$elementSeparator
						.$ISA06__InterchangeSenderID.$elementSeparator
						.$ISA07__InterchangeIDQual.$elementSeparator
						.$ISA08__InterchangeReceiverID.$elementSeparator
						.$ISA09__InterchangeDate.$elementSeparator
						.$ISA10__InterchangeTime.$elementSeparator
						.$ISA11__InterchangeControlStandardIden.$elementSeparator
						.$ISA12__InterchangeControlVersionNum.$elementSeparator
						.$ISA13__InterchangeControlNumber.$elementSeparator
						.$ISA14__AckRequested.$elementSeparator
						.$ISA15__UsageIndicator.$elementSeparator
						.$ISA16__ComponentElementSeperator
						.$segmentTerminator.PHP_EOL);
		   }    

	   
	   /** 
	   * GS - FUNCTIONAL GROUP HEADER
	   * @author : ravinesh 
	   * NOTE: All elements of the GS are REQUIRED
	   * Date : 10:03:2017  
	   **/ 	   
	   public function gsSegmentEDI($recArray,$X12__850__File,$segmentTerminator,$elementSeparator) 
		   {


		   		$GS01__FunctionalGroupHeader=str_replace('@',' ',$recArray["GS01"]);
				$GS02__ApplicationSendersCode=str_replace('@',' ',$recArray["GS02"]);
				$GS03__ApplicationReceiversCode=str_replace('@',' ',$recArray["GS03"]);
				$GS04__GroupDate=str_replace('@',' ',$recArray["GS04"]);
				$GS05__GroupTime=str_replace('@',' ',$recArray["GS05"]);
				$GS06__GroupControlNumber=str_replace('@',' ',$recArray["GS06"]);
				$GS07__ResponsibleAgencyCode=str_replace('@',' ',$recArray["GS07"]);
				$GS08__VersionRelease=str_replace('@',' ',$recArray["GS08"]);
				
				fwrite($X12__850__File, "GS".$elementSeparator.
						$GS01__FunctionalGroupHeader.$elementSeparator.
						$GS02__ApplicationSendersCode.$elementSeparator.
						$GS03__ApplicationReceiversCode.$elementSeparator.
						$GS04__GroupDate.$elementSeparator.
						$GS05__GroupTime.$elementSeparator.
						$GS06__GroupControlNumber.$elementSeparator.
						$GS07__ResponsibleAgencyCode.$elementSeparator.
						$GS08__VersionRelease.$segmentTerminator.PHP_EOL);
		   }

	   


	/** 
	* Transaction Segment Process
	* @author : ravinesh 
	* NOTE: Product Description and Details list
	* Date : 10:03:2017  
	**/    
	public function transactionSegmentEDI($recArray,$X12__850__File,$segmentTerminator,$elementSeparator) 
		{

			//## Start Code For Transaction Loop
			$TransactionData = $recArray;
			## Total Number Of Transaction 
			$totalNumberOfTransaction = sizeof($TransactionData);
			
			$t = 0;
			$ediText = '';
			$asterik = $elementSeparator;
			$tild = $segmentTerminator;

			if(isset($TransactionData[$t])) 
				{
				   $transArray = $TransactionData;	
				}
			else 
				{
				   $transArray = array($TransactionData);	
				}	

			$outputData = $this->TransactionProcess($transArray,$ediText,$asterik,$tild);
			   
			
			fwrite($X12__850__File,$outputData);

		}

     
       public function TransactionProcess($TransactionData,$ediText,$asterik,$tild)
		   {
			   $t = 0;
			   foreach($TransactionData as $TD) :
						
				foreach($TransactionData[$t] as $parentKey=>$parentVal):

				  
					 if($parentKey!="@attributes") //Discard @attributes Field
				        {  
				        
				           $parentValCount = sizeof($parentVal);
				           $start = 0;
				          
				      	 foreach($parentVal as $childKey=>$childVal) 
				      	  {
				      	  	  
						       $asterik = ($start < $parentValCount-1)?'*':'';   


				      	  	   if($start==0 && $parentKey!="Loop") 
						            {
						              $ediText .= $parentKey.'*';	
						            }
					            
					           if($start <= $parentValCount) 
						           {    

						           	    if(is_array($childVal) && empty($childVal)) 
							           	    {  
							           	       $ediText .= $asterik;
							           	    } 
							           	else if(is_array($childVal) && !empty($childVal)) 
								           	{ 
								           		foreach($childVal as $subchildKey=>$subchildVal) 
								           	       {

														 if($subchildKey!="@attributes") 
														    {
														        $subchildValCount = sizeof($subchildVal);

														        $substart = 0;  
														    	
														       foreach($subchildVal as $subsubchildKey=>$subsubChild) 
															       {
															       	   $asterik = ($substart < $subchildValCount-1)?'*':'';  
															       		if($substart == 0) 
													           	       	    {
													           	       	    	$ediText .= $subchildKey."*";
													           	       	    }

													           	       	if($substart <= $subchildValCount) 
								           									{ 

							           											if(is_array($subsubChild) && empty($subsubChild)) 
																	           	    {  
																	           	       $ediText .= $asterik;
																	           	    } 
																	           	else 
																		           	{

																		           	  if(!is_array($subsubChild)) {	
																		           	   $ediText .= $subsubChild.$asterik;
																		           	  }
																		           	}    
								           									}

								           							  $substart++;
								           							  
								           							  if($substart==$subchildValCount)
																           {
																           		$ediText .= "~".PHP_EOL;	
																           }
																         		       
															       }
														    	

											           	       	

														    } 
								           	       	   
								           	       	   
								           	       		
								           	       }
								           			
									      	}    
						           	    else 
							           	    {
							           	      $ediText .= $childVal.$asterik;	
							           	    }
						           		
						           } 
				           
				           
				           $start++;
				           if($start==$parentValCount && $parentKey!="Loop")
					           {
					           		$ediText .= $tild.PHP_EOL;	
					           }

				           
				      	 
				      	 } 
				        }
				         
				    endforeach;  
	        	 	$t++;
				  endforeach;
				return $ediText;  
		   }      		


	   /** 
	   * GE - TRANSACTION SET TRAILER
	   * @author : ravinesh 
	   * NOTE: NOTE: All elements of the GE are required
	   * Date : 10:03:2017  
	   **/ 
	   public function geSegmentEDI($recArray,$X12__850__File,$segmentTerminator,$elementSeparator) 
		   {

		      $GE01__NumberofTransactionSetsIncluded = str_replace('@',' ',$recArray["GE01"]);
		      $GE02__GroupControlNumber = str_replace('@',' ',$recArray["GE02"]);

		      fwrite($X12__850__File, "GE".$elementSeparator.
						$GE01__NumberofTransactionSetsIncluded.$elementSeparator.
						$GE02__GroupControlNumber.
						$segmentTerminator.PHP_EOL);
		   }	


	   /** 
	   * IEA - INTERCHANGE CONTROL TRAILER
	   * @author : ravinesh 
	   * NOTE: All elements of the IEA are required
	   * Date : 10:03:2017  
	   **/ 
	   public function ieaSegmentEDI($recArray,$X12__850__File,$segmentTerminator,$elementSeparator) 
		   {

		      $IEA01__NumberofIncludedFunctionalGroups = str_replace('@',' ',$recArray["IEA01"]);
			  $IEA02__InterchangeControlNumber =  str_replace('@',' ',$recArray["IEA02"]);
			  
			  fwrite($X12__850__File, "IEA".$elementSeparator.
						$IEA01__NumberofIncludedFunctionalGroups.$elementSeparator.
						$IEA02__InterchangeControlNumber.
						$segmentTerminator);

		      
		   }	 

	   /** 
	   * XML To Array Conversion
	   * @author : ravinesh 
	   * NOTE: Filenames  are required
	   * Date : 10:03:2017  
	   **/ 	   
       public function generateXmlToArray($filename) 
			{
    			## XML File Path
    			$filePath = XML_FILE_PATH.$filename;
    			
				## Check Filename Exists Or Not
    			if(!file_exists($filePath)) 
	    			{
	    			 	return array();	
	    			}

	    	    $xml = simplexml_load_file($filePath);
	    	    $xml_array = unserialize(serialize(json_decode(json_encode((array) $xml), 1)));
				return $xml_array; 	
       	   }
	}
?>