<?php

define('WEB_LISTING_LAYOUT', 'web_Project'); //DB LAYOUT
define('FIELD_TO_QUERY','award_status' ); // DB field to query


$publications = array(); // This is for year
$publicationsByGranteeName = array();
$publicationsByAffiliation = array();

    // Query the database
    $cmd =& $fm->newFindCommand(WEB_LISTING_LAYOUT);
    $cmd->addFindCriterion(FIELD_TO_QUERY, "Yes"); 
    $cmd->addSortRule('year_applied',1,FILEMAKER_SORT_DESCEND); 

    $result = $cmd->execute();
    
    if (FileMaker::isError($result)) {
        //If error 
		echo $result->getMessage();
	}
	else
	{
	  //$record = $result->getFirstRecord();
	  //echo $record->getField('project_name');
	
	  $records = $result->getRecords();
          
	  foreach($records as $record){
	     $granteeList = array();
	     $relatedRecords = $record->getRelatedSet('Contact_Project_Join');
		// print_r($relatedRecords);
		 if (FileMaker::isError($relatedRecords)) {
                 
                 }
                 else{
                      foreach($relatedRecords as $relatedRecord){
                       
                       /* Modified by Craig McKessar TSG - Changed sort by Last name then surname - 8 Oct 2013 */
                       $lastName_firstName = $relatedRecord->getField('CONTACT::name_last') . ", " . $relatedRecord->getField('CONTACT::name_first');
                       $granteeList[] = $lastName_firstName;
                       
                       //$granteeList[] = $relatedRecord->getField('CONTACT::c_fullName');
                       
                       //$granteeList[] = $relatedRecord->getField('Contact_Project_Join::_kf_contact_id');

                      }
                 }
	     
                $affiliation =  $record->getField('affiliation');
                $projectName =  $record->getField('project_name');

                if(!empty($granteeList) && !empty($projectName)){ 
                  $informationArray = array('title' => $record->getField('publication_title'),
                                            'link' => $record->getField('publication_link'),
                                            'author' => $record->getField('publication_author'),	
                                            'publisher' => $record->getField('publication_publisher'),
                                            'publication_year' => $record->getField('publication_year'),		
                                            'project_name'=> $record->getField('project_name'),
                                            'affiliation'=> $record->getField('affiliation'),
                                            'year_applied'=> $record->getField('year_applied'),
                                            'granteeList' => $granteeList,
                                           );

                  $publications[$record->getField('year_applied')][] = $informationArray;

                  //by grantee 
                  $authorDisplay = implode(" & ", $granteeList);														   
                  $publicationsByGranteeName[$authorDisplay][] = $informationArray;	

                  //affiliation
                  /* Modified by Craig McKessar TSG - Changed sort by Last name then surname then project name - 8 Oct 2013 */
                  $publicationsByAffiliation[$affiliation . " " . $authorDisplay . " " . $projectName][] = $informationArray;
                  
                  //$publicationsByAffiliation[$affiliation][] = $informationArray;
                } 														   
	  
	  }
	
	}

ksort($publicationsByGranteeName);
ksort($publicationsByAffiliation);
	
//var_dump($publications);
//exit();

$yearList = array_keys($publications);

$yearAnchorLinkArray = array();
foreach($yearList as $yearDisplay){
    $yearAnchorLinkArray[] = '<a href="#'.$yearDisplay.'">'.$yearDisplay.'</a>'; 
}
?>

<div class="content">
    <div class="content_resize">
      <div class="content_resize2">
        <div class="mainbar">
          <div id="byYear" class="article">
            <h4 align="center">&nbsp;</h4>
            <table width="908" border="0" align="left" cellpadding="0">
              <tr>
                <td width="764" colspan="2">
                  Display View by: <select id="viewBy" name="viewBy" onchange="sortOrder('viewBy');">
                                     <option value="year" selected="selected">Year</option>
                                     <option value="name">Grantee Name</option>
                                     <option value="affiliation">Affiliation</option>
                                   </select> 
                </td>
              </tr>
            
              <tr>
                <td width="764"><h4 align="left">
                <?php echo implode(" . ", $yearAnchorLinkArray); ?>
                </h4></td>
                <td width="138"><h1 align="left">Grantees</h1></td>
              </tr>
            </table>
  
            <h1>&nbsp;</h1>
            <p>            
            
            <p>
                
           <?php foreach($publications as $year=>$publication): ?>     
                    <A NAME="<?php echo $year; ?>"></A>
                    <h2><strong><?php echo $year; ?> - <?php echo $year + 1; ?></strong></h2>
                    
                    <blockquote>
                    <?php  foreach($publication as $key=>$items): 
                             $authorDisplay = (!empty($items['link'])) ? '<a href="'.$items['link'].'">'.$items['author'].'</a>' : $items['author'];
                             $authorDisplay = $items['author'];
                             $authorDisplay = implode(" & ", $items['granteeList']);
                    ?> 
                    <p><strong><?php echo $authorDisplay; ?></strong> <?php if(!empty($items['affiliation'])) echo "(".$items['affiliation'].")"; ?><br />
                   
                    <!-- Added link to publication - Craig McKessar TSG 8 Oct 2012 --> 
                    <?php
                        
                        $project_display = $items['project_name'];
                                        
                        if(!empty($items['link'])){
                            echo "<a href='" .$items['link']. "' target=_blank title='View Publication' style='color:#193E45'>".$project_display."</a></BR>";
                        }else{
                            echo $project_display ."</BR>";
                        }
                    ?>
                        
                    <?php  endforeach; ?>  
                         
                     </blockquote>       
           <?php endforeach; ?>  
            
          </div>
          
         
          <div id="byGrantee" class="article" style="display:none;">
            <h4 align="center">&nbsp;</h4>
            <table width="908" border="0" align="left" cellpadding="0">
              <tr>
                <td width="764">
                  Display View by: <select id="viewByGrantee" name="viewByGrantee" onchange="sortOrder('viewByGrantee');">
                                     <option value="year">Year</option>
                                     <option value="name"  selected="selected">Grantee Name</option>
                                     <option value="affiliation">Affiliation</option>
                                   </select> 
                </td>
              <td width="138"><h1 align="left">Grantees</h1></td>
             </tr>
            </table>
  
            <h1>&nbsp;</h1>
            <p>            
            
            <p>
                
           <?php foreach($publicationsByGranteeName as $authorDisplay=>$publication): ?>  
                
                <blockquote>

                <?php  foreach($publication as $key=>$items): ?> 

                     <p><strong><?php echo $authorDisplay; ?></strong> <?php if(!empty($items['affiliation'])) echo "(".$items['affiliation'].")"; ?><br />
                     
                      <!-- Added link to publication - Craig McKessar TSG 8 Oct 2012 -->
                      <?php
                        
                        $project_display = $items['project_name']." (".$items['year_applied'].")";  
                                        
                        if(!empty($items['link'])){
                            echo "<a href='" .$items['link']. "' target=_blank title='View Publication' style='color:#193E45'>".$project_display."</a></BR>";
                        }else{
                            echo $project_display ."</BR>";
                        }
                      ?>

                <?php  endforeach; ?> 

                 </blockquote> 
            
           <?php endforeach; ?> 
            
          </div>
         
          <div id="byAffiliation" class="article" style="display:none;">
             <h4 align="center">&nbsp;</h4>
            <table width="908" border="0" align="left" cellpadding="0">
              <tr>
                <td width="764">
                  Display View by: <select id="viewByAffiliation" name="viewByAffiliation" onchange="sortOrder('viewByAffiliation');">
                                     <option value="year">Year</option>
                                     <option value="name">Grantee Name</option>
                                     <option value="affiliation" selected="selected">Affiliation</option>
                                   </select> 
                </td>
                <td width="138"><h1 align="left">Grantees</h1></td>
              </tr>
              
             
            </table>
  
            <h1>&nbsp;</h1>
            <p>            
            
            <p>
            
            <!-- Generate Affiliate projects. Modified by Craig TSG 8 Oct 2013 to group projects by affiliate -->
            <?php 
                $last_affiliation = "";
                foreach($publicationsByAffiliation as $affiliation=>$publication): 
            ?>     

                <?php                   
                    foreach($publication as $key=>$items): 
                    $authorDisplay = implode(" & ", $items['granteeList']);     
                ?> 
                
                <!-- Close the block quote if we are starting a new affiliation -->
                <?php if($last_affiliation != $items['affiliation'] && $last_affiliation != ""){ ?></blockquote><?php } ?>
                
                <!-- Create the affiliation header -->
                <?php if($last_affiliation != $items['affiliation']){?>
                    <blockquote>
                    <p><strong><?php echo $items['affiliation']; ?></strong><br />
                <?php } ?>
                
                <!-- Generate the projects associated with the affiliate -->
                <!-- Added link to publication - Craig McKessar TSG 8 Oct 2012 -->
                <?php        
                    
                    if(!empty($authorDisplay)){
                      $project_display = $items['project_name'] . " (".$authorDisplay.")" ." (".$items['year_applied'].")";  
                    }else{
                      $project_display = $items['project_name'];  
                    }                 
                    
                    if(!empty($items['link'])){
                        echo "<a href='" .$items['link']. "' target=_blank title='View Publication' style='color:#193E45'>".$project_display."</a></BR>";
                    }else{
                        echo $project_display ."</BR>";
                    }
                ?>
            
                <?php $last_affiliation = $items['affiliation'];  ?>
                        
                <?php  endforeach; ?>  
                     
           <?php endforeach; ?>           
          
          
          </div>
         </div>
        <div class="clr"></div>
      </div>
    </div>
  </div>
  

      <div class="clr"></div>
    </div>
  </div>
 <script>
     
  function sortOrder(selectBoxId){
    var selectValue = $('#' + selectBoxId).val();
    
       if(selectValue == "year"){
         $('#byGrantee').hide();
         $('#byAffiliation').hide();
         $('#byYear').show();
         $('#viewBy').val('year'); 
       }
       if(selectValue == "name"){
         $('#byGrantee').show();
         $('#byAffiliation').hide();
         $('#byYear').hide();
         $('#viewByGrantee').val('name'); 
       }
       if(selectValue == "affiliation"){
         $('#byGrantee').hide();
         $('#byAffiliation').show();
         $('#byYear').hide();
         $('#viewByAffiliation').val('affiliation'); 
       }  
  
  }
 </script> 