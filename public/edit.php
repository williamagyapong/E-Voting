<?php
require_once'../core/init.php';

if(isset($_POST['edit-voter'])) {
	$_SESSION['EDIT'] = "voter";
	$_SESSION['EDIT-ID'] = $_POST['id'];

} elseif(isset($_POST['edit-candidate'])) {
	$_SESSION['EDIT'] = "candidate";
	$_SESSION['EDIT-ID'] = $_POST['id'];

} elseif(isset($_POST['edit-office'])) {
	$_SESSION['EDIT'] = "office";
	$_SESSION['EDIT-ID'] = $_POST['id'];

}  

//handle editing of data
if(isset($_POST['save1'])) {

	if(DB::getInstance()->update('voters', $_SESSION['EDIT-ID'], [
		 'firstname'=>ucwords($_POST['fname']),
         'lastname'=>ucwords($_POST['lname']),
         'gendar'=>ucwords($_POST['gender'])
		] )) {
		redirect('voters');
	}
} elseif(isset($_POST['save2'])) {
      //print_array($_FILES['image']); die();
	if(!empty($_FILES['image']['name'])) {

		if(uploadImage($_FILES['image'])) {

			if(DB::getInstance()->update('candidates', $_SESSION['EDIT-ID'], [

				 'firstName'=>ucwords($_POST['fname']),
		         'lastName'=>ucwords($_POST['lname']),
		         'office_id'=>$_POST['office'],
		         'images'=>$_FILES['image']['name']
				] )) {
				  redirect('candidates');
			      }
		}
	} else {
		if(DB::getInstance()->update('candidates', $_SESSION['EDIT-ID'], [

				 'firstName'=>ucwords($_POST['fname']),
		         'lastName'=>ucwords($_POST['lname']),
		         'office_id'=>$_POST['office']
		    
				] )) {
				  redirect('candidates');
			      }
	}
} elseif(isset($_POST['save3'])) {

	if(DB::getInstance()->update('offices', $_SESSION['EDIT-ID'], [
		 'office'=>ucwords($_POST['office'])
		] )) {
		redirect('viewoffice');
	}
} 

?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit page</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
   <?php 
   require 'includes/header.php';
   ?>
   
   <div class="wrapper">
   	  <?php if(isset($_SESSION['EDIT']) && $_SESSION['EDIT']=="voter"):
   	     $voter = getVoter('voters', $_SESSION['EDIT-ID']);
   	  ?>
     <form action="edit.php" method="post">
	     <fieldset class="fieldset">
	  	 <legend>Edit voter credentials</legend>
	  <div style=" padding-left: 20%">
        <table class="table">
        <?php
          foreach($voter as $value) {
        ?>
        <tr>
     	<td>First Name</td><td><input class="text-input" type="text" name="fname" value="<?php echo $value['firstname']?>"></td> 
     	</tr>
     	<tr>
     	<td>Last Name</td><td><input class="text-input" type="text" name="lname" value="<?php echo $value['lastname']?>"></td>
     	</tr>
        <tr>
     	<td>Gender</td><td><input class="text-input" type="text" name="gender" value="<?php echo $value['gendar']?>"></td>
     	</tr>
   
       <tr>
     	<td></td><td><input type="submit" name ="save1" value="Save Changes" class="submit-btn"></td>
       </tr>
     	<?php } ?>
     	</table>
     </div>
      </fieldset>
     </form>

     <?php elseif(isset($_SESSION['EDIT']) && $_SESSION['EDIT']=="candidate"): 
         $candidate = getCandidate($_SESSION['EDIT-ID']);
     ?>
     
      <form action="edit.php" method="post" enctype="multipart/form-data">
	     <fieldset class="fieldset">
	  	 <legend>Edit candidate credentials</legend>

	  	<img src="images/<?php echo $candidate['images'];?>" width="140" height= "140" style="float:right">
	   <div style=" padding-left: 10%">
        <table class="table">
        <tr>
     	   <td>First Name</td><td><input class="text-input" type="text" name="fname" value="<?php echo $candidate['firstName']?>"></td> 
     	</tr>
     	<tr>
     	   <td>Last Name</td><td><input class="text-input" type="text" name="lname" value="<?php echo $candidate['lastName']?>"></td>
     	</tr>
        
        <tr>
           <td>Image</td><td><input type ="file" name="image"></td>
        </tr>
        <tr>
     	   <td>Office</td>
     	   <td>
     	   <select name= "office">
     	   	  <option value="<?php echo $candidate['office_id']?>"><?php echo $candidate['office']?>
     	   <!-- display available offices -->	  	
     	   	  <?php
     	   	    $offices = getOffices();
                foreach($offices as $office) {
                if($office['office']==$candidate['office']) continue;//skip
               echo "<option value='".$office['id']."'>".$office['office']."</option>";
              }
            ?> 
     	   </select>
     	</td>
     	</tr>
   
       <tr>
     	<td></td><td><input type="submit" name ="save2" value="Save Changes" class="submit-btn"></td>
       </tr>
     	</table>
     </div>
      </fieldset>
    </form>

    <?php elseif(isset($_SESSION['EDIT']) && $_SESSION['EDIT']=="office"):
   	     $office = getOffices($_SESSION['EDIT-ID']);
        
   	  ?>
     <form action="edit.php" method="post">
	     <fieldset class="fieldset">
	  	 <legend>Edit Office</legend>
	  <div style=" padding-left: 20%">
        <table class="table">
        <tr>
        	<td>Office</td>
        	<td><input class="text-input" type="text" name="office" value="<?php echo $office['office']?>" ></td>
        </tr>
   
       <tr>
     	<td></td><td><input type="submit" name ="save3" value="Save Changes" class="submit-btn"></td>
       </tr>
  
     	</table>
     </div>
      </fieldset>
     </form>
      
     <?php endif;?>
   </div>

    <?php 
   require 'includes/footer.php';
   ?>
</body>
</html>