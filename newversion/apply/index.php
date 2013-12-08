<?php
$strPathToRoot = "../";
$strPathToIncludes = $strPathToRoot."includes/";
$title = "Application Form";
  
require_once("${strPathToIncludes}config.php");

$page = "content.php";
$errors = array();
//Form Submission
if(isset($_POST['formSubmitted']) && $_POST['formSubmitted'] == 1){
  //Create dynamic variable 
  foreach($_POST as $key =>$value){
   if(!is_array($_POST[$key])) 
	$$key = $value;
  }  
  
  $firstName = clearDefaultFormValue($firstName,'First Name');
  $lastName = clearDefaultFormValue($lastName,'Last Name');
  
  $address1 = clearDefaultFormValue($address1,'Address Line 1');
  $address2 = clearDefaultFormValue($address2,'Address Line 2');
  $city = clearDefaultFormValue($city ,'City');
  $zip = clearDefaultFormValue($zip,'Zip');
  $state = clearDefaultFormValue($state ,'State');
  $country = clearDefaultFormValue($country,'Country');
  
  $fieldsToCheck = array("firstName" => array('value'=>$firstName, 'message'=>"Please enter your first name."),
  						 "lastName"  => array('value'=>$lastName, 'message'=>"Please enter your last name."),
  						 "address1"  => array('value'=>$address1, 'message'=>"Please enter address line 1."),
  						 "city"  => array('value'=>$city, 'message'=>"Please enter your city."),
  						 "state"  => array('value'=>$state, 'message'=>"Please enter your state."),
  						 "zip"  => array('value'=>$zip, 'message'=>"Please enter your zip."),
  						 "country"  => array('value'=>$country, 'message'=>"Please enter your country."),
  						 "phonePrimary"	=> array('value'=>$phonePrimary, 'message'=>"Please enter your primary phone."),
  						 "phonePrimaryType"	=> array('value'=>$phonePrimaryType, 'message'=>"Please enter your primary phone type."),
  						 "projectName"	=> array('value'=>$projectName, 'message'=>"Please enter your project name."),
  						 "yearApplied"	=> array('value'=>$yearApplied, 'message'=>"Please enter your year applied."),
  						 "location"	=> array('value'=>$location, 'message'=>"Please enter your location."),
  						 "affiliation"	=> array('value'=>$affiliation, 'message'=>"Please enter your affiliation."),
  						 "yearFundsRequested" => array('value'=>$yearFundsRequested,"message"=>"Please enter years of funds requested")
  						);
  //Check for empty fields
  foreach($fieldsToCheck as $key=>$fieldArray){
     if(empty($fieldArray['value'])) $errors[] = $fieldArray['message'];
  }	
  
  //Check email address
  if(empty($emailAddress1) && empty($emailAddress2))
    $errors[] = "Please enter atleast one email address.";
  
  if(empty($errors)){
    //Create contact database record
    $insertArray = array('name_first'=>$firstName,"name_last"=>$lastName,"street"=>$address1,"city"=>$city,"state"=>$state,
    					 "zip"=>$zip,"country"=>$country,'phone_primary'=>$phonePrimary,'phone_primary_type'=>$phonePrimaryType);
    if(!empty($phoneSecondary)) $insertArray['phone_secondary'] = $phoneSecondary;
    if(!empty($phoneSecondaryType)) $insertArray['phone_secondary_type'] = $phoneSecondaryType;
    if(!empty($emailAddress1)) $insertArray['email_primary'] = $emailAddress1;
    if(!empty($emailAddress2)) $insertArray['email_secondary'] = $emailAddress2;
    
    $cmd =& $fm->newAddCommand('web_contact', $insertArray);
	$resultContact = $cmd->execute();
	if (FileMaker::isError($resultContact)){ 
	 echo $resultContact->getMessage();		
    }
    else{
      //Get the contact id
      $recordContact = $resultContact->getFirstRecord();
      $contactId = $recordContact->getField('__KP_CONTACT_ID');
      
      //Create project Record
      $insertArray = array('project_name'=>$projectName, 'location'=>$location,'affiliation'=>$affiliation, 'year_applied'=>$yearApplied,
      						'years_funding_requested'=>$yearFundsRequested);
      $cmd =& $fm->newAddCommand('web_Project', $insertArray);
	  $resultProject = $cmd->execute();
	  if (FileMaker::isError($resultProject)){ 
	    echo $resultProject->getMessage();		
      }
      else{
        //get the project id
        $recordProject = $resultProject->getFirstRecord();
        $projectId = $recordProject->getField('__KP_PROJECT_ID');
        
        //create the project join record
        $insertArray = array('_kf_project_id'=> $projectId,'_kf_contact_id'=>$contactId);
        $cmd =& $fm->newAddCommand('web_contact_project_join', $insertArray);
	    $result = $cmd->execute();
	    if (FileMaker::isError($result)){ 
	      echo $result->getMessage();		
        }
	  }
    }
    
    //Email notification
    
    //direct to form submission page
    //$page = "content.php";
    $page =  "contentConfirmation.php";
  }
}
//end of form submission
require_once("${strPathToIncludes}header.php");

//Set View
require_once($page);

require_once("${strPathToIncludes}footer.php");?>


?>