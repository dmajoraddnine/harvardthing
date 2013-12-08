<?php
define('WEB_LISTING_LAYOUT', 'web_Project'); //DB LAYOUT
define('FIELD_TO_QUERY','publication_status' ); // DB field to query


$publications = array();

    //Query the database
    $cmd =& $fm->newFindCommand(WEB_LISTING_LAYOUT);
	$cmd->addFindCriterion(FIELD_TO_QUERY, "Published"); 
	$cmd->addSortRule('publication_year',1,FILEMAKER_SORT_DESCEND); 
		 
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
	     $publications[$record->getField('publication_year')][] = array('title' => $record->getField('publication_title'),
	     															'link' => $record->getField('publication_link'),
	     															'author' => $record->getField('publication_author'),	
	     															'publisher' => $record->getField('publication_publisher'),
	     															'publication_year' => $record->getField('publication_year')		
	     														   );
	  
	  }
	
	}
//var_dump($publications)	;
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
          <div class="article">
            <table width="915" border="0" cellpadding="0">
              <tr>
                <td width="750">
                <h4>
                <?php echo implode(" . ", $yearAnchorLinkArray); ?>
                </h4></td>
                <td width="159"><h1>Publications</h1></td>
              </tr>
            </table>
            <h4 align="center">&nbsp;</h4>
                    <h3>You can also view White Levy publications in the <a href="http://bobcat.library.nyu.edu/primo_library/libweb/action/search.do?dscnt=0&amp;vl%28378633853UI1%29=all_items&amp;scp.scps=scope%3A%28NS%29%2Cscope%3A%28CU%29%2Cscope%3A%28%22BHS%22%29%2Cscope%3A%28NYU%29%2Cscope%3A%28%22NYSID%22%29%2Cscope%3A%28%22NYHS%22%29%2Cscope%3A%28GEN%29%2Cscope%3A%28%22NYUAD%22%29&amp;frbg=&amp;tab=all&amp;dstmp=1377875999976&amp;srt=rank&amp;ct=search&amp;mode=Basic&amp;dum=true&amp;vl%28212921975UI0%29=creator&amp;indx=51&amp;vl%281UIStartWith0%29=contains&amp;vl%28freeText0%29=white+levy+program&amp;vid=NYU&amp;fn=search" target="_new">ISAW database</a>.</h3>
                    <p>&nbsp;</p>
            
 <?php foreach($publications as $year=>$publication): ?>     
            <A NAME="<?php echo $year; ?>"></A>
            <h2><strong><?php echo $year; ?></strong></h2>
            <blockquote>
    <?php  foreach($publication as $key=>$items): 
             $authorDisplay = (!empty($items['link'])) ? '<a href="'.$items['link'].'">'.$items['author'].'</a>' : $items['author'];
    ?> 
              <p><?php echo $authorDisplay; ?><br />
                <em><?php echo $items['title']; ?></em>. <?php echo $items['publisher']; ?>, <?php echo $items['publication_year']; ?> </p>
    <?php  endforeach; ?> 
            </blockquote>        
  <?php endforeach; ?>  
  
          </div>
    
        </div>
        <div class="clr"></div>
      </div>
    </div>
  </div>