<?php
      $firstName = defaultFormValue($firstName,'First Name');
	  $lastName = defaultFormValue($lastName,'Last Name');
	  
	  $address1 = (!$address1)? "Address Line 1" : $address1; 
	  $city = (!$city)? "City" : $city; 
      $zip = (!$zip)? "Zip" : $zip; 
      $state = (!$state)? "State" : $state; 
      $country = (!$country)? "USA" : $country; 
      
      $countryDropDown =  generateDropDown($countries , $country, "country", 1,1,1,1);
	  $phonePrimaryTypeDropDown = generateDropDown($otherPhoneTypes,$phonePrimaryType,"phonePrimaryType",1,0,1,1);      
	  $phoneSecondaryTypeDropDown = generateDropDown($otherPhoneTypes,$phoneSecondaryType,"phoneSecondaryType",1,0,1,1);      

?>
	 
<div class="content">
    <div class="content_resize">
      <div class="content_resize2">
        <div class="mainbar">
         <form id="memberAreaForm" name="memberAreaForm" method="POST">
         <input type="hidden" name="formSubmitted" value="1" />	
		  <div id="memberArea" class="article">
            
            <?php
			   //if errors then display message
			   if(!empty($errors)){
				echo "<div id='errorBlock' style='padding:30px; background: none repeat scroll 0 0 #FFCCCC; border: 1px solid #DD7777;'>
				      <b>We are unable to process your application due to the following errors below:</b>
				      <ul>";
				foreach($errors as $errorMessage){
				 echo "<li>".$errorMessage."</li>";
				}
				echo "</ul></div>";
			   } 
            ?>
            <div id="contactBlock">
			   <fieldset>
			   <legend>Application Form:</legend>
			     <div>
				   <div class="label">Name:</div>
				   <div class="formInputElement"> 
				     <input type="text" name="firstName" class="bigText"  id="firstName" size="5" value='<?php echo $firstName; ?>' onclick="setBlank('firstName','First Name');" onblur="setBlur('firstName','First Name');" /> &nbsp;
				     <input type="text" name="lastName" class="bigText"  id="lastName" size="5" value='<?php echo $lastName; ?>' onclick="setBlank('lastName','Last Name');" onblur="setBlur('lastName','Last Name');"/>&nbsp;
				   </div>
				  </div>
				  <div class="spacer"></div>
				  <div>
				   <div class="label">Address:</div>
				   <div class="formInputElement"><input type="text" name="address1" id="address1" value='<?php echo $address1; ?>' onclick="setBlank('address1','Address Line 1');" onblur="setBlur('address1','Address Line 1');"/></div>
				  </div>
				  <div class="spacer"></div>
				  <!--<div>
				   <div class="label"></div>
				   <div class="formInputElement"><input type="text" name="address2" id="address2" value='<?php echo $address2; ?>' onclick="setBlank('address2','Address Line 2');" onblur="setBlur('address2','Address Line 2');"/></div>
				  </div>
				  <div class="spacer"></div>-->
				  <div>
				   <div class="label"></div>
				   <div class="formInputElement">
				   <input type="text" name="city" class="bigText"  id="city" size="5" value='<?php echo $city; ?>' onclick="setBlank('city','City');" onblur="setBlur('city','City');"/> &nbsp;
				   <input type="text" name="state" class="smallText" id="state"  value='<?php echo $state; ?>' onclick="setBlank('state','State');" onblur="setBlur('state','State');"/>, &nbsp; 
				   <input type="text" name="zip" class="smallText" id="zip" size="5" value='<?php echo $zip; ?>' onclick="setBlank('zip','Zip');" onblur="setBlur('zip','Zip');"/>

				   </div>
				  </div>
				  <div class="spacer"></div>
				  <div>
				   <div class="label"></div>
				   <div class="formInputElement"><?php echo $countryDropDown; ?></div>
				  </div>
				  
				  <div class="spacer"></div>
				  <div>
				   <div class="label">Primary Phone:</div>
				   <div class="formInputElement"><input type="text" name="phonePrimary" id="phonePrimary" value='<?php echo $phonePrimary; ?>' />&nbsp; 
				    <?php echo $phonePrimaryTypeDropDown; ?>&nbsp; </div>
				  </div>
				  <div class="spacer"></div>
				  <div>
				   <div class="label">Secondary Phone:</div>
				   <div class="formInputElement"><input type="text" name="phonePrimary" id="phonePrimary" value='<?php echo $phonePrimary; ?>' />&nbsp; 
				    <?php echo $phoneSecondaryTypeDropDown; ?>&nbsp; </div>
				  </div>
				  <div class="spacer"></div>
				  
				  
				  
				  <div>
				   <div class="label">Email Addresses:</div>
				   <div class="formInputElement"><input type="text" name="emailAddress1" id="emailAddress1" value='<?php echo $emailAddress1; ?>' /></div>
				  </div>
				  <div class="spacer"></div>
				  <div>
				   <div class="label"></div>
				   <div class="formInputElement"><input type="text" name="emailAddress2" id="emailAddress2" value='<?php echo $emailAddress2; ?>'/></div>
				  </div>
				  <div class="spacer"></div>
				  
				  <div>
				   <div class="label">Project Name:</div>
				   <div class="formInputElement"><input type="text" name="projectName" id="projectName" value='<?php echo $projectName; ?>' /></div>
				  </div>
				  <div class="spacer"></div>
				 
				  <div>
				   <div class="label">Year Applied:</div>
				   <div class="formInputElement"><input type="text" name="yearApplied" id="yearApplied" value='<?php echo $yearApplied; ?>' /></div>
				  </div>
				  <div class="spacer"></div>
				 
				  <div>
				   <div class="label">Location:</div>
				   <div class="formInputElement"><input type="text" name="location" id="location" value='<?php echo $location; ?>' /></div>
				  </div>
				  <div class="spacer"></div>
				  
				  <div>
				   <div class="label">Affiliation:</div>
				   <div class="formInputElement"><input type="text" name="affiliation" id="affiliation" value='<?php echo $affiliation; ?>' /></div>
				  </div>
				  <div class="spacer"></div>
				  
				  <div>
				   <div class="label">Years of Funds Requested:</div>
				   <div class="formInputElement"><input type="text" name="yearFundsRequested" id="yearFundsRequested" value='<?php echo $yearFundsRequested; ?>' /></div>
				  </div>
				  <div class="spacer"></div>
				  
				  <div>
				   <div style="height:15px;">&nbsp;</div>
				  </div>
				  <div class="spacer"></div>
				  
				  <div id="formButtonArea">
			       <input type="submit" class="submitText" name="submit" value="Submit" />
			      </div>   
			      <div style="clear:both;">&nbsp;</div>
			  
			   </fieldset>
			  </div><!-- end of contact block-->
			  
			  
			
           
           
          </div>
         </form>
          
        </div>
        <div class="clr"></div>
      </div>
    </div>
  </div>
<script>
function setBlank(fieldID, fieldValue){
 
  if($('#'+fieldID).val() == fieldValue)
   $('#'+fieldID).val('');
}

function setBlur(fieldID, fieldValue){
  if($('#'+fieldID).val() == '')
   $('#'+fieldID).val(fieldValue);
}
</script>