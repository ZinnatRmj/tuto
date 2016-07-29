<?php

class db { 

	protected static $instance   ;
	public $error ;
	private $con = false  ; 
	public $_result ;  
	private $autocommit = true  ;
	
	private function __construct() {
		$this-> initialize() ; 
	}
	protected function initialize() { 
		$conf = new conf() ; 
		
		$this->con = new mysqli( conf::$server, conf::$username , conf::$password, conf::$database );  
		
		$this->con->set_charset("utf8") ;
		if ( $this->con->connect_errno ) {
			// TODO better redirect 
			printf("Connect failed: %s\n", $this->con->connect_error );
			exit();
		} 
		return true ;
	}
	// call_user_func
	public static function getInstance() { 
		if( ! db::$instance ) 
			db::$instance = new db() ;
		return db::$instance ; 
	}
	public function get( $sql  ) {
	
		if ( ! $this -> con ) return false ;
		$this -> _result = false ;
	
		$result = $this->con->query( $sql ) ;
	
		if ( $result ) {			
			$row = $result->fetch_row() ;			
			$result->close();
			return $row ;
		}

		http_response_code(400);
		return $this -> error .= " Exe failed $sql ". $this->con->error ;
	
	}
	public function getRow( $sql , $type = 'object' ) { 
		
		if ( ! $this -> con ) return false ; 
		$this -> _result = false ; 
		
		$result = $this->con->query( $sql ) ;		
		
		if ( $result ) { 
			if ( $type == 'array' ){ 
				$row = $result->fetch_assoc() ;
				foreach ((array)$row as $k => $v)
					$row[ $k ] = $v ;
			} else {
				$row =  $result->fetch_object() ;
				foreach ((array)$row as $k => $v)
					$row-> $k = $v ; // utf8_encode( $v )
			}
			$result->close(); 
			return $row ;
		} 
		http_response_code(400);
		return $this -> error .= " Exe failed $sql ". $this->con->error ; 
	}
	public function getAll ( $sql , $type = 'object' ) {
	
		if ( ! $this -> con ) return false ;
		$this -> _result = false ;
	
		$result = $this->con->query( $sql ) ;
	
		if ( $result ) {
			$all = array () ;
			if ( $type == 'array' ){
				while ($obj = $result->fetch_assoc()) {
					foreach ((array)$obj as $k => $v)
						$obj[ $k ] =  $v  ;
					$all [] = $obj ;
				}
			} else {
				while ($obj = $result->fetch_object()) {
					foreach ((array)$obj as $k => $v)
						$obj -> $k =  $v ; // 
					$all [] = $obj ;
				}
			}
			$result->close();
			return $all ;
		}
		http_response_code(400);
		return $this -> error .= " Exe failed $sql ". $this->con->error;
		
	}
	public function Execute ($sql) {
		if ( ! $this -> con ) return false ; 
		$this -> _result = false ; 
		
		$result = $this->con->query( $sql ) ;		
		
		if ( ! $result  ) { 
			http_response_code(400);
			return $this -> error .= " Exe failed $sql ". $this->con->error ;
		}

		return true ;
		
	}
	public function getNum ( $sql ) {
		if ( ! $this -> con ) return false ; 
		$result = $this->con->query( $sql ) ;
		return $result->num_rows;
	}
	public function autocommit( $set = true  ){
		$this -> con -> autocommit( $set ) ;
		$this -> autocommit = $set ;
		$this ->con -> commit() ;
	}
	public function commit ( ) {
		$this ->con -> commit() ;		
	}
	public function rollback ( ) {
		$this -> con -> rollback ( ) ;
	}
	public function getInserted(){
		return $this ->con->insert_id ;
	}
}