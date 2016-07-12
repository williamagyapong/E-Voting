<?php 
session_start();
/*
*requirements
*/
 require '../core/config.php';
 require_once'create_db.php';
 
 //free session variables
   unset($_SESSION['EDIT']);
   unset($_SESSION['EDIT-ID']);
   
 auth(); //prevents unauthorized entry
 
 $elections = getElection();//initialize election variable
 
 if(isset($_GET['electid'])) {
    
    //set election session variable to switch between elections
     $_SESSION['ELECTID'] = $_GET['electid'];
     
 } 
 if(isset($_SESSION['ELECTID'])) {
    $isON = $_SESSION['ELECTID'];//use as stamp to track active election
 }else{
    $isON = 0;//zero means election has not been selected
 }
?>
<!DOCTYPE html>
<html>
   <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>dashboard</title>
     <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <style type="text/css">
    	li{
    		font-weight: bold;
    		font-size: 18px;
    	}
    </style>
   </head>
   <body>
   	 <?php 
    require_once 'includes/header3.php';
    
  ?>
 <div class="wrapper">
    <div>
       <h2>
       <!-- destroy election upon request -->
         <?php 
            if(isset($_GET['destroy'])) {
                destroyElection();
            }
         ?>
      </h2>
    </div>
    <!-- display selected election -->
    <?php if(isset($_SESSION['ELECTID'])):?>
    
    <center>
        <h2><?php echo getElection($_SESSION['ELECTID'])[0]['name'];?></h2>
    </center>
    <?php endif; ?>
    <nav class="navbar navbar-default" role="navigation">
    	<div class="container-fluid">
    		
    		<ul class="nav navbar-nav">
    		  <li class="dropdown">
    		  	<a href="#" class="dropdown n-toggle" data-toggle="dropdown" role="button" area-expanded="false">Create<span class="caret"></span></a>
    		  	  <ul class="dropdown-menu" role="menu">
    		  	  	<li><a href="create-elect.php">Election</a></li>
    		  	  	<li class="divider"></li>

    		  	  	<li><a href="office.php">Offices</a></li>
    		  	  </ul>
    		  </li>

    		  <li class="dropdown">
    		  	<a href="#" class="dropdown n-toggle" data-toggle="dropdown" role="button" area-expanded="false">Register<span class="caret"></span></a>
    		  	  <ul class="dropdown-menu" role="menu">
    		  	  	<li><a href="candregister.php">Candidates</a></li>
    		  	  	<li class="divider"></li>

    		  	  	<li><a href="register.php">Voters</a></li>
                    </ul>
                </li>
    		  	
    		  </li>

    		  <li class="dropdown">
    		  	<a href="#" class="dropdown n-toggle" data-toggle="dropdown" role="button" area-expanded="false">Display<span class="caret"></span></a>
    		  	  <ul class="dropdown-menu" role="menu">
    		  	  	<li><a href="viewoffice.php">Offices</a></li>
    		  	  	<li class="divider"></li>

    		  	  	<li><a href="candidates.php">Candidates</a></li>
    		  	  	<li class="divider"></li>

    		  	  	<li><a href="voters.php">Voters</a></li>
                    <li class="divider"></li>
                    
    		  	  	<li><a href="results.php">Results</a></li>
    		  	  	
    		  	  </ul>
    		  </li>

    		  <li>
                <a href="login.php" target="_blank">Voting Section</a>
                 </li>

    		  <li class="dropdown">
    		  	<a href="#" class="dropdown n-toggle" data-toggle="dropdown" role="button" area-expanded="false">Settings<span class="caret"></span></a>
    		  	  <ul class="dropdown-menu" role="menu">
    		  	  	
                  <li>  <a href="#" data-toggle="modal" aria-controls="collapse-post" data-target="#elections">
              <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
              <span class="hidden-xs hidden-sm">Select Election</span>
              </a></li>
    		
                    <li class="divider"></li>
                    <li><a href="logout.php?close">Close Election</a></li>
                    <li class="divider"></li>

                    <li><a href="dashboard.php?destroy" onclick="return submitAlert()">Destroy Election</a></li>
                    <li class="divider"></li>

                    <li><a href="control.php?clear" onclick="return submitAlert2()">Reset Voting</a></li>

                    
    		  	  </ul>
    		  </li>

    		  <li class="dropdown">
    		  	<a href="#" class="dropdown n-toggle" data-toggle="dropdown" role="button" area-expanded="false">Administrator<span class="caret"></span></a>
    		  	  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Logged in as: <?php echo $_SESSION['ADMIN'] ?></a></li>
                    <li class="divider"></li>

    		  	  	<li><a href="changepass.php">Change Password</a></li>
    		  	  	<li class="divider"></li>
            <li><a href="adminlogout.php">Logout</a></li>
    		  	  	
    		  	  </ul>
    		  </li>

    			
    		</ul>
    	</div>
    </nav>
    
    
    <!-- Modal for displaying elections -->
    <div id="elections" class="modal fade" role="dialog"  data-backdrop=false >
      <div class="modal-dialog" style="width:90%">

        <!-- Modal content-->
        <div class="modal-content">  
          <div class="modal-header ">
            <h3 class="modal-title title" style="text-align:center; color:blue">Available Elections</h3>
          </div>
          <div class="prev-modal-body">
             <?php if(empty($elections)): ?>
               <h2>No Elections</h2>
               <a href = "create-elect.php">create election</a>
             <?php else:?>
             <table class="table2" style="width:88%; margin-left:5.5%;" title="Click on name of election to select it">
               <tr>
                 <th>Name</th>
                 <th>Institution</th>
                 <th>Voters</th>
                 <th style="border-right:#ccc">Action</th>
               </tr>
             
            <?php
               foreach($elections as $election) {
            ?>
            <!-- display content-->
            <tr>
                <td title="click to select">
                 <ul class="nav navbar-nav">
                   <li>
                    <a href="create-elect.php?electid=<?php echo $election['elect_id']?>"><?php echo $election['name'] ?></a>
                    </li>
                 </ul>
                </td>
                <td><?php echo $election['institute']?></td>
                <td><?php echo $election['voters']?></td>

                <td class="edit">
                    <form action= "create-elect.php" method="post">
                     <input type="hidden" name="id" value = "<?php echo $election['elect_id'];?>">
                     <input type ="submit" name="edit-election" value="[ Edit ]" title="Make changes">
                   </form>
               </td>
            </tr>
          <?php } ?>
          </table>
          <?php endif; ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
     </div>
    </div> 
  </div>
 </div>

<?php

require_once 'includes/footer.php';
?>
    
    <script type="text/javascript" src = "js/jQuery.js"></script>
    
    <script src="js/bootstrap.min.js"></script>

    <script type="text/javascript">

         

        function submitAlert() {
            
            var isON = "<?php echo $isON ?>";
            
            if(isON>0) {
               if(confirm("You are about to destroy a complete election ! Click OK to proceed or Cancel to stop.")) {
                return true;
            } else {
                return false;
            }
            }else if(isON ==0){
               alert("Sorry, there is no election to destroy");
               return false;
            }
            
        }

         function submitAlert2() {

            if(confirm("Doing this will clear all votings if any. Click OK to continue or Cancel to stop !")) {
                return true;
            } else {
                return false;
            }
        }

    </script>
</body>
</html>
