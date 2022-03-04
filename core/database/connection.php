<?php
session_start();
  

class DB
{
	// use the singleton pattern
	private static $_instance = null;
    
	// set other properties
	private $_pdo,
	        $_query,
	        $_results,
	        $_error = false,
	        $_counter = 0;

	/**
	*
	* Constructor 
	*/
	private function __construct() 
    {
	    	//connects to the selected database
		if(isset($_SESSION['ELECTID'])) {
	        
			$dbName = 'election'.$_SESSION['ELECTID'];

		      try{
		             $this->_pdo = new PDO('mysql:host=127.0.0.1;dbname='.$dbName, 'root','');
		       	    //$this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
		       } catch(PDOException $e) {
		       	   //die($e->getMessage());
		           //Redirect::to(401);//pass a system failure message
		       	   die('System failure');
		       }
		}
	
       
	}

	/**
	* get db instance method
	*@return db instance
	*
	*/
	public static function getInstance() 
  {
		// create a new db instance only if it has not already been instantiated
		if(! isset(self::$_instance)) 
    {
			self::$_instance = new DB();
		}

		return self::$_instance;
	}

   
   public function query($sql, $params= array()) 
   {
   	   $this->_error = false;
   	   if($this->_query = $this->_pdo->prepare($sql)) {
   	   	 
   	   	  $index = 1;
   	   	  if(count($params)) {
   	   	  	  foreach($params as $param) {
   	   	  	  	 $this->_query->bindValue($index, $param);

   	   	  	  	 $index++;
   	   	  	  }
   	   	  }

   	   	 if($this->_query->execute()) {
   	   	      $this->_results = $this->_query->fetchAll(PDO::FETCH_ASSOC);
   	   	      $this->_count = $this->_query->rowCount();
   	     } else {
   	     	  $this->_error = true;
   	     }

   	   }

   	   return $this;//implement method chainning
   }


   public function action($action, $table, $where = array()) {
   	   if(count($where) === 3) {
   	   	  //define allowable operators
   	   	  $operators = array('=', '!=', '<', '>', '<=', '>=', 'like', 'REGEXP');
          
   	   	  $field    = $where[0];
   	   	  $operator = $where[1];
   	   	  $value    = $where[2];

   	   	  if(in_array($operator, $operators)) {
   	   	  	 //construct sql;
   	   	  	 $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

   	   	  	 if(! $this->query($sql, array($value))->getError()) {
   	   	  		 return $this;//implement method chainning
   	   	  	 }
   	   	  }

   	   } elseif(count($where) == 0) {
            $sql = "{$action} FROM {$table}";
            if(!$this->query($sql, array())->getError()) {
               return $this;
            }
       }
   	   return false;

   }


   public function get($table, $where) 
   {
        return $this->action('SELECT *', $table, $where);
   }

   public function select($sql) 
   {
       $query = $this->_pdo->prepare($sql);
       $query->execute();
       $this->_results = $query->fetchAll(PDO::FETCH_ASSOC);
       return $this;
   }

   public function all() {
   	   return $this->_results;
   }

   public function first() {
   	   if(!empty($this->_results))
       {
        return $this->_results[0];
       }
   }

   /**
   * insert data into database
   *@param table|data
   *@return boolean
   */
   public function insert($table, $data = array()) {
        //check if there is data in data array
   	    if(count($data)) {
           $fields = array_keys($data);
           $values = null;
           $index = 1;
           
            foreach($data as $value){
           	    $values .= '?';
	           	if($index < count($data)) {
                   $values .= ', ';
	           	}
	           	$index++;
           }
           
           $sql = "INSERT INTO {$table} (`". implode('`, `', $fields). "`) VALUES({$values})";
           
           if(! $this->query($sql, $data)->getError()) {
           	   return true;//on success
           }
           
   	    }
   	    return false; //on error
   }


   public  function existsSpecial($table, array $field1, array $field2) 
   {
        $sql = "SELECT * FROM {$table} WHERE ";

        foreach($field1 as $key=>$value){
          $sql .= "{$key} = '{$value}' AND ";
        }

        foreach($field2 as $key => $value) {
           $sql .= "{$key} = '{$value}'";
        }
   
        $query = $this->_pdo->prepare($sql);
        $query->execute();
        
        if($query->rowCount()==1) {
            return true;
        }
        return false;
   }


   public function update($table, $fieldValue, $data=array(),  $tableField = "id") 
   {
   		if(count($data)) {
   			$set = '';
   			$counter = 1; 

   			foreach($data as $field => $value) {
   				$set .= "{$field} = ?";
   				if($counter < count($data)) {
   					$set .= ",";
   				}
   				$counter++;
   			}
            
   			$sql = "UPDATE {$table} SET {$set} WHERE {$tableField} = '{$fieldValue}'";

   			if(!$this->query($sql, $data)->getError()) {
   				return true;//success
   			} 
   				
   		   return false; //error
   			
   		}

   }
   

 public function update2( $table, array $where, array $data, $operator=null)
 {
    $fieldsValues ="";
    foreach($data as $field =>$value)
    {
       if($operator && is_numeric($value)) {
         $fieldsValues .= '`'.$field.'` = '.'`'.$field.'` '.$operator." '$value',";
       } else {
        $fieldsValues .= '`'.$field.'` = '."'$value',";
       }
       
    }

    $fieldsValues = rtrim($fieldsValues,",");
    foreach($where as $key => $id) 
    {

         $sql = "UPDATE ". '`'.$table.'` '. "SET ".$fieldsValues." WHERE ".'`'.$key.'` ='.$id;
           //echo $sql;die();
        $query = $this->_pdo->prepare($sql);
       if($query->execute()){
          return true;
       }
       return false;

   }
    
 }



   /**
   * update database records
   * @param data|array clause|string
   * @var
   * @return boolean
   */
   public function updateSpecial($table, array $data, $whereSql)
   {
      if(count($data)) {
        $set = '';
        $counter = 1; 

        foreach($data as $field => $value) {
          $set .= "{$field} = ?";
          if($counter < count($data)) {
            $set .= ",";
          }
          $counter++;
        }
            
        $sql = "UPDATE {$table} SET {$set} WHERE {$whereSql}";

        if(!$this->query($sql, $data)->getError()) {
          return true;//success
        } 
          
         return false; //error
        
      }
     
   }

   
   
   public function delete($table, $where, $sql=null) {
        if($sql) {
        	$query = $this->_pdo->prepare($sql);
        	if($query->execute()){
	          return true;
	       }
	       return false;
        } else {
        	return $this->action('DELETE', $table, $where);
        }
   }

   public function count() {
   	   return $this->_count;
   }

   public function lastInsertedId() {
      return $this->_pdo->lastInsertId();
   }

   public function getError() {
       return $this->_error;
   }
}
?>
