<?php
require_once'../core/init.php';

 
 if (isset($_GET['clear'])) {
     if(clearVoting()){
        redirect('dashboard');
     }

     redirect('dashboard');//temporary usage - get back later to fix problem with clear function
 }

