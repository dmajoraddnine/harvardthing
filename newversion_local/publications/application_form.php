<?php

/*
 * Built by: Craig McKessar - TSG - 9 Oct 2013
 */

session_start();

$strPathToRoot = "../";
$strPathToIncludes = $strPathToRoot."includes/";
$title = "Online Application Form";

?>

<!-- Set the View -->

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>The Shelby White &amp; Leon Levy Program: Online Application</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<link href="style.css" rel="stylesheet" type="text/css" />

<style>
    
    #application_title{


        margin: 0 auto;

        margin-bottom: -38px;
        margin-top: 5px;
        
        width: 300px;
        text-align: center;
    }
    
    input{
        display: inline !important;
        position:relative;
        margin-right: 8px;
        
    }
    
    input[type=text], input[type=date], input[type=tel]{
        display: block;
        width: 160px;
        height: 26px;
        padding: 2px;
        font-family: arial;
        font-size: 12px;
    }
    
    input[type=email]{
        display: block;
        width: 300px; 
        height: 26px;
        padding: 2px;
    }
    
    input[name=project_name]{
        width: 760px;
    }

    input[name=location], input[name=affiliation]{
        width: 300px;
    }
    
    #submit_div{
               margin: 0 auto;
               width: 100px;
               text-align:center;
    }
    
    input[type=submit] {
        
        margin: 0 auto;
        -moz-box-shadow:inset 0px 1px 0px 0px #f5978e;
	-webkit-box-shadow:inset 0px 1px 0px 0px #f5978e;
	box-shadow:inset 0px 1px 0px 0px #f5978e;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #98471F), color-stop(1, #7A310D) );
	background:-moz-linear-gradient( center top, #98471F 5%, #7A310D 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#98471F', endColorstr='#7A310D');
                
        
	background-color:#7A310D;
        
        -webkit-border-radius:6px;
        -moz-border-radius:6px;
        border-radius:6px;
    
	text-indent:0;
	border:1px solid #7A310D;
	display:inline-block;
	color:#ffffff;
	font-family:Arial;
	font-size:12px;
	font-weight:bold;
	font-style:normal;
	height:30px;
	line-height:30px;
	width:80px;
	text-decoration:none;
	text-align:center;
	text-shadow:1px 1px 0px #572004;
        cursor: pointer;
        
        margin-top: 14px;
    }
    
    input[type=submit]:hover {
    	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #7A310D), color-stop(1, #98471F) );
	background:-moz-linear-gradient( center top, #7A310D 5%, #98471F 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#7A310D', endColorstr='#98471F');
	background-color:#c62d1f;
    }

    input[type=submit]:active {
            position:relative;
            top:1px;

    }
    
    fieldset{
        margin-top: 40px;
        margin-left: 9px;
        margin-right: 9px;
        margin-bottom: 9px;
    }
    
    legend{
        font-weight: bold;
        color: #98471F;
        font-size: 15px;
    }
    
    label{
        display: inline-block;
        /*
        display: inline-block;
        margin-top: 10px;*/
        color: black;
    }
    
    .field_label{
        width: 120px;
    }
    
    .field_label_instruction{
        width: 120px;
        font-size: 11px;
        color: dark-grey;
        text-decoration: italic;
        
    }
    
    .field_row{
        display: block;
        margin-top: 10px;
        margin-left: 3px;
    }
    
    #submit_error{
        margin-top: 50px;
        margin-left: 10px;
        margin-right: 10px;
        margin-bottom: -20px;
        padding: 5px;
        border: 1px solid red;
        background-color: pink;
        color: red;
    }
    
    #image_captcha{
        margin: 0 auto;
        width: 300px;
        text-align:center;
    }
    
    #image_captcha input, #image_captcha a{
        margin: 0 auto;
        display: block;
    }
    
    #image_captcha a, #image_captcha label{
        margin-top: 10px;
    }
    
</style>

</head>
<body>

<?php 

require_once("${strPathToIncludes}config.php");
  
require_once("${strPathToIncludes}header.php");

?>



<div class="content">
    <div class="content_resize">
      <div class="content_resize2">

              
          <h2 id="application_title">Online Application Form</h2>
          
          <!-- Server side validation error -->
          <?php

              if($_SESSION['submit_error'] !== "" and isset($_SESSION['submit_error'])){
                  echo "<p id=submit_error>";
                  echo $_SESSION['submit_error'];
                  echo "</p>";

                  unset($_SESSION['submit_error']);

              }
          ?>  
              
          <form id="online_application_form" action="application_form_process.php" method="post">
              
              <fieldset>
                  
                  <legend>Grantee Information</legend>
                  
                  <div class="field_row">
                      <label for="name_first" class="field_label">First Name:</label>
                      <input type="text" name="name_first" value="<?php echo $_SESSION['fields']['name_first']; ?>"></input>
                  </div>
                  
                  <div class="field_row">
                      <label for="name_last" class="field_label">Last Name:</label>
                      <input type="text" name="name_last" value="<?php echo $_SESSION['fields']['name_last']; ?>"></input>
                  </div>
                  
                  <div class="field_row">
                      <label for="street" class="field_label">Street:</label>
                      <input type="text" name="street" value="<?php echo $_SESSION['fields']['street']; ?>"></input>
                  </div>
                  
                  <div class="field_row">
                      <label for="city" class="field_label">City:</label>
                      <input type="text" name="city" value="<?php echo $_SESSION['fields']['city']; ?>"></input>
                  </div>
                  
                  <div class="field_row">
                      <label for="state" class="field_label">State:</label>
                      <input type="text" name="state" value="<?php echo $_SESSION['fields']['state']; ?>"></input>
                  </div>
                  
                  <div class="field_row">
                      <label for="zip" class="field_label">Zip Code:</label>
                      <input type="text" name="zip"value="<?php echo $_SESSION['fields']['zip']; ?>"></input>
                  </div>
                  
                  <div class="field_row">
                      <label for="country" class="field_label">Country:</label>
                      <input type="text" name="country" value="<?php echo $_SESSION['fields']['country']; ?>"></input>
                  </div>
                  
                  <div class="field_row">
                      <label for="phone_primary" class="field_label">Work Phone:</label>
                      <input type="tel" name="phone_primary" value="<?php echo $_SESSION['fields']['phone_primary']; ?>"></input>
                  </div>
                  
                  <div class="field_row">
                      <label for="phone_secondary" class="field_label">Home Phone:</label>
                      <input type="tel" name="phone_secondary" value="<?php echo $_SESSION['fields']['phone_secondary']; ?>"></input>
                  </div>
                  
                  <div class="field_row">
                      <label for="email_primary" class="field_label">Email:</label>
                      <input type="email" name="email_primary" value="<?php echo $_SESSION['fields']['email_primary']; ?>"></input>
                  </div>
                  
                  <div class="field_row">
                      <label for="email_secondary" class="field_label">Email 2:</label>
                      <input type="email" name="email_secondary" value="<?php echo $_SESSION['fields']['email_secondary']; ?>"></input>
                  </div>
                  
                  
              </fieldset>
              
              <fieldset>
                  
                  <legend>Project Information</legend>
                  
                  <div class="field_row">
                      <label for="project_name" class="field_label">Project Name:</label>
                      <input type="text" name="project_name" value="<?php echo $_SESSION['fields']['project_name']; ?>"></input>
                  </div>
                  
                  <div class="field_row">
                      <label for="year_applied" class="field_label">Year Applying:</label>
                      <input type="text" name="year_applied" value="<?php echo $_SESSION['fields']['year_applied']; ?>"></input>
                  </div>
                  
                  <div class="field_row">
                      <label for="location" class="field_label">Site Location:</label>
                      <input type="text" name="location" value="<?php echo $_SESSION['fields']['location']; ?>"></input>
                  </div>
                  
                  <div class="field_row">
                      <label for="affiliation" class="field_label">Affiliation:</label>
                      <input type="text" name="affiliation" value="<?php echo $_SESSION['fields']['affiliation']; ?>"></input>
                  </div>
                  <span class="field_label_instruction">(Enter 'none' for 'No Affiliation')</span>
                  
                  <div class="field_row">
                      <label for="expected_publication_date" class="field_label">Expected Publication Year:</label>
                      <input type="text" name="expected_publication_date" value="<?php echo $_SESSION['fields']['expected_publication_date']; ?>"></input>
                  </div>
                  
              </fieldset>
              
              <div id="image_captcha">
                  <img id="captcha" src="<?php echo $strPathToIncludes;?>securimage/securimage_show.php" alt="CAPTCHA Image" />
                  
                  <label for="captcha_code">Please enter image text below</label>
                  <input type="text" name="captcha_code" size="10" maxlength="6" />
                    <a href="#" onclick="document.getElementById('captcha').src = '<?php echo $strPathToIncludes;?>securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>
              </div>
              
              <div id="submit_div">
                  <input type="Submit" value="Submit"></input>
              </div>
              
          </form>

      </div>
    </div>
</div>
 

<script>
$(function() {
     $( ".dateRepaired" ).datepicker();
});
</script>
    
<!-- JQUERY FORM VALIDATOR -->
<script>

$().ready(function() {

	// validate form on keyup and submit
	$("#online_application_form").validate({
                
		rules: {
			name_first: "required",
			name_last: "required",
                        street: "required",
                        city: "required",
                        zip: "required",

                        country: "required",

			email_primary: {
				required: true,
				email: true
			},                     
                        
			project_name: "required",
                        year_applied: "required",
                        location: "required",
                        affiliation: "required",
                        expected_publication_date: "required"
                        
		},
		messages: {
			name_first: "Please enter your firstname.",
			name_last: "Please enter your lastname.",
			email_primary: "Please enter a valid email address.",
                        email_secondary: "Please enter a valid email address.",
			project_name: "Please enter a project name."
		}
	});
});

</script>
    
<?php
require_once("${strPathToIncludes}footer.php");

unset($_SESSION['fields']);

?>

