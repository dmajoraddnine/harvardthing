<?php

function clearDefaultFormValue($fieldValue,$defaultValue){
   $returnValue = ($fieldValue == $defaultValue) ? "":$fieldValue;
   return $returnValue;

}


function defaultFormValue($fieldValue,$defaultValue){
   $returnValue = (empty($fieldValue)) ? $defaultValue:$fieldValue;
   return $returnValue;
}

//generate drop downs
function generateDropDown($inputArray, $selectedValue="", $inputName, $size=4,$type=0, $insertBlank=0,$required=0,$javascript="" ){
   $required = ($required)?'class="required"':"";
   $jsCode = ($javascript)?$javascript:"";	
   $dropDownHtml = '<select size="'.$size.'" name="'.$inputName.'" id="'.$inputName.'" '.$required.' '.$jsCode.'>';
   if($insertBlank)
	 $dropDownHtml .= '<option value="">-</option>';
   
	   foreach($inputArray as $key=>$value)
	   {
		  if($type){ 
		  $selected =  ($value == $selectedValue) ? 'selected="'.$selected.'"' : '';
		  $dropDownHtml .= '<option value="'.$value.'" '.$selected.'>'.$value.'</option>';
		  }else{
		  $selected =  ($key == $selectedValue) ? 'selected="selected"' : '';
		  $dropDownHtml .= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
		  }
	   }
   
   $dropDownHtml .= '</select>';
  
   return $dropDownHtml;
}
 

 

?>