<?php

/*
 * Built by: Craig McKessar - TSG - 9 Oct 2013
 */

session_start();

$strPathToRoot = "../";
$strPathToIncludes = $strPathToRoot."includes/";
$title = "Online Application Form";

/* Perform some server side validation incase javascript is disabled in the browser */

if(
        $_POST['name_first'] === "" || 
        $_POST['name_last'] === "" ||
        $_POST['street'] === "" ||
        $_POST['city'] === "" ||

        $_POST['zip'] === "" ||
        $_POST['country'] === "" ||

        $_POST['email_primary'] === "" ||
        
        $_POST['project_name'] === "" ||
        $_POST['year_applied'] === "" ||
        $_POST['location'] === "" ||
        $_POST['affiliation'] === "" ||
        $_POST['expected_publication_date'] === ""
){
    
    $errorMessage = "Please make sure you complete the following fields before submitting: <br />";
    if($_POST['name_first'] === "") $errorMessage .= "- First Name <br />";
    if($_POST['name_last'] === "") $errorMessage .= "- Last Name <br />";
    if($_POST['street'] === "") $errorMessage .= "- Street <br />";
    if($_POST['city'] === "") $errorMessage .= "- City <br />";

    if($_POST['zip'] === "") $errorMessage .= "- Zip Code <br />"; 
    if($_POST['country'] === "") $errorMessage .= "- Country <br />"; 

    if($_POST['email_primary'] === "") $errorMessage .= "- Email <br />"; 
    
    if($_POST['project_name'] === "") $errorMessage .= "- Project Name <br />"; 
    if($_POST['year_applied'] === "") $errorMessage .= "- Year Applying <br />"; 
    if($_POST['location'] === "") $errorMessage .= "- Site Location <br />"; 
    if($_POST['affiliation'] === "") $errorMessage .= "- Affiliation (Enter 'none' for 'No Affiliation'.)<br />"; 
    if($_POST['expected_publication_date'] === "") $errorMessage .= "- Expected Publication Year <br />"; 
    
    $_SESSION['submit_error'] = $errorMessage;
    $_SESSION['fields'] = $_POST; // Save post values so that the user does not have to re-type them
    
    header('Location: application_form.php');
    exit();
    
}else{
    
    /* Field validation passed */
    
    /* Now check if the image capture text is correct */
    include_once $strPathToIncludes . '/securimage/securimage.php';

    $securimage = new Securimage();

    if ($securimage->check($_POST['captcha_code']) == false) {
      // the code was incorrect
       $_SESSION['fields'] = $_POST; // Save post values so that the user does not have to re-type them
       $_SESSION['submit_error'] = 'The text you entered was different to the text in the image. <br /> Please type the text exactly as it appears in the image before resubmitting the form.';

       header('Location: application_form.php');
       exit();
    }
    
    unset($_SESSION['submit_error']);
    unset($_SESSION['fields']);
}

require_once("${strPathToIncludes}config.php");

/* Process the form */

/* Add grantee as a new record in the contacts table */

$new_grantee = $fm->newAddCommand('web_contact');

/* Set the fields */
$new_grantee->setField('name_first', $_POST['name_first']);
$new_grantee->setField('name_last', $_POST['name_last']);
$new_grantee->setField('street', $_POST['street']);
$new_grantee->setField('city', $_POST['city']);
$new_grantee->setField('state', $_POST['state']);
$new_grantee->setField('zip', $_POST['zip']);
$new_grantee->setField('country', $_POST['country']);
$new_grantee->setField('phone_primary', $_POST['phone_primary']);
$new_grantee->setField('phone_secondary', $_POST['phone_secondary']);
$new_grantee->setField('email_primary', $_POST['email_primary']);
$new_grantee->setField('email_secondary', $_POST['email_secondary']);

$new_grantee_result = $new_grantee->execute();


/* If the first record fails to create don't try and create any other related records */
if (FileMaker::isError($result)) {
    $createRecordError = "True";
}

$grantee_records = $new_grantee_result->getFirstRecord();

foreach($grantee_records as $grantee_record){
    $grantee_record_id = $grantee_record->getField('__KP_CONTACT_ID');
}

/* Add project as a new record in the project table */

if($createRecordError !== "True"){
    
    $new_project = $fm->newAddCommand('web_Project');

    /* Set the fields */
    $new_project->setField('project_name', $_POST['project_name']);
    $new_project->setField('year_applied', $_POST['year_applied']);
    $new_project->setField('location', $_POST['location']);
    $new_project->setField('affiliation', $_POST['affiliation']);
    $new_project->setField('expected_publication_date', $_POST['expected_publication_date']);


    
    $new_project_result = $new_project->execute();
    $project_records = $new_project_result->getFirstRecord();

    foreach($project_records as $project_record){
        $project_record_id = $project_record->getField('__KP_PROJECT_ID');
    }
}

/* Add the join record to Contact_Project_Join */
if($createRecordError !== "True"){
    $new_projectcontact = $fm->newAddCommand('web_contact_project_join');

    /* Set the fields */
    $new_projectcontact->setField('_kf_project_id', $project_record_id);
    $new_projectcontact->setField('_kf_contact_id', $grantee_record_id);

    $new_projectcontact_result = $new_projectcontact->execute();
}

?>

<!-- Set the View -->

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>The Shelby White &amp; Leon Levy Program: Online Application</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link href="style.css" rel="stylesheet" type="text/css" />

<style>
    
    .content_resize2{
        height: 40% !important;
    }

    #confirmation_message{
        margin-left: 20px;
    }
    
</style>

</head>
<body>

<?php 
  
require_once("${strPathToIncludes}header.php");

?>

<div class="content">
    <div class="content_resize">
      <div class="content_resize2">
          
        <?php 
        
        if($createRecordError == "True"){
            echo "<p id=confirmation_message >This system was unable to create a record at this time. Please press the back button and try resubmitting again later. </p>";
        }else{
            
            /*
             * ******  APPLICANT CONFIRMATION EMAIL ******
             */
            
            /* Send an email confirmation to the applicant using swift mailer */
            require_once("${strPathToIncludes}/swift_mailer/lib/swift_required.php");
            
            // Create the mail transport configuration
            $transport = Swift_MailTransport::newInstance();
            
            /*
            // To configure sending via SMTP (Comment out the above new Instance)
            $transport = Swift_MailTransport::newInstance("smtp.example.com", 25);
            $message->setUsername("your username");
            $message->setPassword("your password");
             */

            // Create the message
            $message = Swift_Message::newInstance();
            $message->setTo(array(
              $_POST['email_primary'] => "online applicant"
            ));
            $message->setSubject("White Levy Grant Application Information Received");
            
$messageBody = <<<END
     
Thank you for submitting your information. Please remember to send a PDF of your application (abstract, related information, budget, and any images) to info@whitelevy.org. We will send you a confirmation email once we have received this application.
    
Thank you,

Kate van West
White Levy Program Coordinator
        
END;
            
            $message->setBody($messageBody);
            $message->setFrom("whitelev@fas.harvard.edu", "White Levy");

            // Send the email
            $mailer = Swift_Mailer::newInstance($transport);
            $mailer->send($message);
            
            
            
            /*
             * ******  WHITE LEVY APPLICATION SUBMITTED EMAIL ******
             */
            
            /* Send an email to White Levy notifying them of the new application */
            require_once("${strPathToIncludes}/swift_mailer/lib/swift_required.php");
            
            // Create the mail transport configuration
            $transport = Swift_MailTransport::newInstance();
            
            /*
            // To configure sending via SMTP (Comment out the above new Instance)
            $transport = Swift_MailTransport::newInstance("smtp.example.com", 25);
            $message->setUsername("your username");
            $message->setPassword("your password");
             */

            // Create the message
            $message = Swift_Message::newInstance();
            $message->setTo(array(
              "whitelev@fas.harvard.edu" => "White Levy"
            ));
            $message->setSubject("Project submitted online by " . $_POST['name_first'] . " " . $_POST['name_last']);
            
            $projectName = $_POST['project_name'];
            $yearApplied = $_POST['year_applied'];
            $location = $_POST['location'];
            $affiliation = $_POST['affiliation'];
            $expected_publication_date = $_POST['expected_publication_date'];
            
$messageBody = <<<END
     
Project Name:  $projectName
Year Applied:  $yearApplied
Location:  $location
Affiliation:  $affiliation
Expected Publication Year:  $expected_publication_date
        
END;
            
            $message->setBody($messageBody);           
            
            $message->setFrom("whitelev@fas.harvard.edu", "White Levy");

            // Send the email
            $mailer = Swift_Mailer::newInstance($transport);
            $mailer->send($message);
        ?>  
        <p id="confirmation_message">Thankyou for submitting your application. A confirmation email will be sent to you shortly.</p>
        <?php } ?>
      </div>
    </div>
</div>
        
</body>
    
<?php
require_once("${strPathToIncludes}footer.php");
?>
