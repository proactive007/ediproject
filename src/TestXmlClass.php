<?php

$xml = simplexml_load_file("EDI_02032017.xml");

$xml_array = unserialize(serialize(json_decode(json_encode((array) $xml), 1)));

//## Start Code For Transaction Loop
$TransactionData = $xml_array["FunctionGroup"]["Transaction"];



## Total Number Of Transaction 
$totalNumberOfTransaction = sizeof($TransactionData);

$t = 0;
$ediText = '';
$asterik = '*';
$tild = "~";

 foreach($TransactionData as $TD) :
    
    foreach($TransactionData[$t] as $parentKey=>$parentVal):
        
       if($parentKey!="@attributes") //Discard @attributes Field
        {  
        
           $parentValCount = sizeof($parentVal);
           $start = 0;
          
      	 foreach($parentVal as $childVal) 
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
										    	
										       foreach($subchildVal as $subsubChild) 
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
														           		$ediText .= $subsubChild.$asterik;
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

//## End Code For Transaction Loop
echo "<pre>";
print_r($ediText);
echo "</pre>";
?>


<?php
/*
$xml = simplexml_load_file("EDI_02032017.xml");

$xml_array = unserialize(serialize(json_decode(json_encode((array) $xml), 1)));





//## Start Code For Transaction Loop
$TransactionData = $xml_array["FunctionGroup"]["Transaction"];

## Total Number Of Transaction 
$totalNumberOfTransaction = sizeof($TransactionData);

$t = 0;
$ediText = '';
$asterik = '*';
$tild = "~";

 foreach($TransactionData as $TD) :
    
    foreach($TransactionData[$t] as $parentKey=>$parentVal):
        
       if($parentKey!="@attributes") //$parentKey=="Loop" && 
        {  
        
           $parentValCount = sizeof($parentVal);
           $start = 0;
          
      	 foreach($parentVal as $childVal) 
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
				           		//$tild = '';
				           			
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

//## End Code For Transaction Loop
echo "<pre>";
print_r($ediText);
echo "</pre>";
*/
?>