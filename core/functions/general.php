<?php

    $config_appName = "E-VOTING";
	// Add developer's credentials below 
	$developer = "William Ofosu Agyapong"; 
	$developer_email = "willisco AT live DOT com";

function escape($str)
{
	$str =  mysql_real_escape_string($str);
	//$str =  strip_tags($str);
	//$str =  htmlentities($str);

	return $str;
}


function electionSelected() {
	if(isset($_SESSION['ELECTID'])) {
		return true;
	} else {
		return false;
	}
}

function redirect($destination)
{
   header("Location: {$destination}.php");
}

function isEven($value)
{
	return $value % 2 == 0;
}

function isOdd($value)
{
	return isEven($value - 1);
}

function print_array($array)
{
	echo '<pre>',print_r($array, true),'</pre>';
}

function formatTime($x)
{
	if ($x < 10) 
	{
		$x = '0'.$x;
	}
	return $x;
}

function countDown($dateStarted, $duration)
{
	date_default_timezone_set("UTC");

$startedAt = strtotime($dateStarted);
$currtime = time();


$timeElapsed = $currtime - $startedAt;
$remaining   = ($duration*60) - $timeElapsed; 

$seconds     = $remaining;
$minutes = floor($remaining/60);
$hours   = floor($remaining/3600);
//$days    = floor($diffInSeconds/86400);

$minutes %= 60;
$hours  %=24;
$seconds %=60;

if($remaining <=0)
{
	$mins = '00';
	$hrs  = '00';
	$secs = '00';

	
}
else{
	 	$mins = formatTime($minutes);
		$hrs  = formatTime($hours);
		$secs = formatTime($seconds);
}



   return  array($remaining, $hrs.":".$mins.":".$secs);
}


function numEncrypt($value)
{
  $result = $value/34534998876;
  return $result;
}

function numDecrypt($value)
{
	$result = $value*34534998876;
	return round($result);
}
	
function deleteRecord($table, $idField="id", $id)
{
	$sql = "DELETE FROM " .'`'.$table.'`'." WHERE ". '`'.$idField.'` = '. $id;
	
	if(mysql_query($sql))
	{
		return true;
	}
	else
		return false;
}	


function getSettings()
{
	return select("SELECT * FROM settings");
}


function truncateString($string)
{
	$length = strlen($string);
	if($length >= 19)
	{
		return substr($string, 0,17)."...";
	}else{
		return $string;
	}
}

function uploadImage($file)
 { 

    if(isset($file))
    {

      if((($file['type']=="image/jpeg")||
         ($file['type']=="image/gif") ||
         ($file['type']=="image/pjpeg"))/*&&
         ($_FILES[$file]['size']<100000)*/)
        {
          
            if(move_uploaded_file($file['tmp_name'], "images/".$file['name']))
            {
            	return true;
            } 
        }
        else{

          return false;
        }  
    }
}


/**
*faciliates pagination of returned results
*
*@param $table|string, $idField|string, $pageRows|int
*
*@return array($result|array,$pageControls|string, $text|string)
*/
function paginate($table=null, $pageRows=10, $idField='id')
{
   if ($table)
   {  
   	    $sql = "SELECT COUNT($idField) FROM ".'`'.$table.'`';
	    $run = mysql_query($sql);
	    $row = mysql_fetch_row($run);
	    $rows = $row[0];

      //get the last page number
      $lastPage = ceil($rows/$pageRows);
      
      //make room for at least one page
      if ($lastPage<1)
      {
      	 $lastPage = 1;
      }

      //set page number variable and initialize it to 1;
      $pageNum = 1;
      //get page number from url
      if (isset($_GET['pn']))
      {  
      	//ensures page number is set to values from 0-9
      	 $pageNum = preg_replace('#[^0-9]#', '', $_GET['pn']);
      }

      // ensures page number is not below 1 or greater than the last page number
      if($pageNum<1)
      {
      	$pageNum = 1;
      } elseif ($pageNum>$lastPage)
      {
      	$pageNum = $lastPage;
      }

      //set range of rows to return
      $limit = 'LIMIT '. ($pageNum-1)*$pageRows.','.$pageRows;
      
      if($table == 'candidates') {
      	$result = select("SELECT candidates.*,office FROM candidates, offices WHERE candidates.office_id=offices.id  ORDER BY offices.office ASC $limit");

      } else{
      	  $result = select("SELECT * FROM ".'`'.$table.'`'." $limit");
      }
      

      //initialize necessary variables
      $text1 ="Voters (<b>$rows</b>)";
      $text2 ="Page <b>$pageNum</b> of <b>$lastPage</b>";
      $pageControls = '';
      
      //prepare page control buttons where there are more than 1 pages
      if($lastPage !=1)
	   {
		   	  //provide a links to pages where there are more than one page numbers
		      if($pageNum>1)
		      {
		        $previous = $pageNum-1;
		        $pageControls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'">Previous</a> &nbsp; &nbsp';
		         
		        //render clickable number links that should appear on the left of the target page number
		        for($i = $pageNum-4; $i<$pageNum; $i++)
		        {   
		           //this loop iterates 4 times
		          
		          if($i>0)
		          {
		            $pageControls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; &nbsp';
		          }
		        }
		      
		        
		      }
		      
		      // render the target page number, but without it being a link 
		      $pageControls .=''.$pageNum.' &nbsp; ';

		      //render clickable number links that should appear on the right of the target page number
		      for($i = $pageNum+1; $i<=$lastPage; $i++)
		      {
		        $pageControls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; &nbsp';

		        //break out of the loop in order not to render page numbers which don't correspond to any valid page
		        if($i>= $pageNum+4)
		        {
		          break;
		        }
		       
		      }
		      // provide the next handler
		      if($pageNum !=$lastPage)
		        {
		          $next = $pageNum+1;
		          $pageControls .= ' &nbsp;<a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'">Next</a>';
		        }
	   }

	   //return values
	   return array($result, $pageControls, $text2 );

   } else {
        
   }
}#paginate function ends here

function backTo($url)
{
	if(isset($_POST['submit'])) {
	header("Location: $url.php");
}
}
?>