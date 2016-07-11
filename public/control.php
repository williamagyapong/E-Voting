<?php
require_once'../core/init.php';

 
 if (isset($_GET['clear'])) {
     if(clearVoting()){
        redirect('dashboard');
     }
 }

