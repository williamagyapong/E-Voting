<?php 
//session_start();
 require_once '../core/init.php';
 
 auth2();//prevents unathorized entry

 //select candidates
 if(isset($_POST['select-office'])) {
   
   $_SESSION['office-id'] = $_POST['office-id']; 
   
}  
 if(isset($_SESSION['office-id'])) {
    $officeId = $_SESSION['office-id'];
    $office  = getOffices($officeId);
    $candidates = getCandidateByOffice($officeId);

 }
   
?>
<!DOCTYPE html>
 <html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cast vote</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">

   <style type="text/css">
      body{
      /*margin:0;
      padding: 0;
      background-color: #c0c0c0;*/
    }
    </style>
  </head>
  <body> 

  <?php 
    require_once 'includes/header2.php';
    
  if(isset($_POST['submit'])) {
      if(castvote()==false){
  ?>
  <div class="back">
       <span>Sorry, you have already voted in this office</span>
  </div>

  <?php 
     } 
   }
  ?>
    
  <div class="castvote">
        <div>Candidates for <?php echo $office['office'];?> </div>
      <?php if(empty($candidates)):?>
        <h2>No candidate available</h2>

      <?php else:?>
      <form action="castvote.php" method="post" onsubmit="return myAlert()">

      <?php
      //display candidates 
           foreach($candidates as $candidate) {
            
      ?>
         <span class="">
             <input type="radio" name = "candid" style="width:30px; height:30px; cursor:pointer;"   value="<?php echo $candidate['id'];?>">

             <input type="hidden" name = "office-id" value="<?php echo $office['id']?>" >
             
             <img src = "images/<?php echo $candidate['images'] ?>" width="200" height="250" title="Vote <?php echo $candidate['firstName']?> as <?php echo $office['office']?>">
         </span>
         
      <?php
        }
    
      ?>
         <p><input type="submit" name="submit"  value="CAST VOTE" class="castvote-btn">
           <input type="reset" value="Reset" class="castvote-btn">
         </p>
        </form>
     <?php endif; ?>
 </div>

 <?php
  require_once 'includes/footer.php';
?>
<script type="text/javascript" src="js/jQuery.js"></script>
<script type="text/javascript">
  
   function myAlert()
      {
         var myForm     = document.forms[0];
         var candId     = myForm.candid.value;
         if(candId ==""){
            if(confirm("You did not vote for any candidate. It will be assumed you've voted")){
              return true;
            }else{
             return false;
         }
         }else{
            return true;
         }

      }
   
</script>
</body>
</html>