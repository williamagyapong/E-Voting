<?php
require_once '../database/connection.php';

$sql = "SELECT COUNT(id) FROM `voters`";
    $run = mysql_query($sql);
    $row = mysql_fetch_row($run);
    $rows = $row[0];
    $page_rows = 10;
    $last = ceil($rows/$page_rows);
    //echo $last;die();

    if($last<1)
    {
      $last = 1;
    }
    
    $page_num = 1;
    if(isset($_GET['pn']))
    {
       $page_num = preg_replace('#[^0-9]#', '', $_GET['pn']);
       
    }
    //handle invalid page numbers, negatives in this case
    if($page_num<1)
    {
      $page_num = 1;
    }
    // ensure page number does not exceed the last page number
    elseif($page_num>$last)
    {
       $page_num = $last;
    }
       //limit x, y: select y starting from x
       $limit = 'LIMIT '.($page_num-1)*$page_rows .','. $page_rows;
       //ECHO $limit; die();
    $sql2 = "SELECT * FROM voters  $limit";
    $run2 = mysql_query($sql2);

    $textline1 ="Voters (<b>$rows</b>)";
    $textline2 ="Page <b>$page_num</b> of <b>$last</b>";
    $pagenation_ctrls = '';
   if($last !=1)
   {
      if($page_num>1)
      {
        $previous = $page_num-1;
        $pagenation_ctrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'">previous</a> &nbsp; &nbsp';
         
        //render clickable number links that should appear on the left of the target page number
        for($i = $page_num-4; $i<$page_num;$i++)
        {   
           //this loop iterates 4 times
          
          if($i>0)
          {
            $pagenation_ctrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; &nbsp';
          }
        }
      
        
      }
      
      // render the target page number, but without it being a link 
      $pagenation_ctrls .=''.$page_num.' &nbsp; ';

      //render clickable number links that should appear on the right of the target page number
      for($i = $page_num+1; $i<=$last; $i++)
      {
        $pagenation_ctrls .= '<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp; &nbsp';

        //break out of the loop in order not to render page numbers which don't correspond to any valid page
        if($i>= $page_num+4)
        {
          break;
        }
       
      }
      // provide the next handler
      if($page_num !=$last)
        {
          $next = $page_num+1;
          $pagenation_ctrls .= ' &nbsp;  <a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'">Next</a>';
        }
   }

   $list = '';
   $counter = 0;
   while($row2 = mysql_fetch_assoc($run2))
   { 
     $counter++;
     $ftname = $row2['firstname'];
     $lname  = $row2['lastname'];
     $gender = $row2['gendar'];
     $voterid = $row2['voterid'];
     $ID      = $row2['id'];

     $list .="<p>".$counter.' '.$ftname.' &nbsp '.$lname.' &nbsp; &nbsp '.$gender.' &nbsp; &nbsp '.$voterid."</p>";
   }
    //close database connection
    //mysql_close()

   ?>

   <style type="text/css">
     label{
      font-family: verdana;
      font-weight: bold;
      color: blue;
     }
   </style>
<div style="min-width:50% ;min-height: 400px; border: 1px solid black; padding-left: 50px; ">
  <h2><?php echo $textline1;?></h2>
   <h2><?php echo $textline2;?></h2>

   <div>
     <p><?php echo $list;?></p>
   </div>
</div>
   

   <div><?php echo $pagenation_ctrls;?></div> 