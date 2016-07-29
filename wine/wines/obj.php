<?php

require_once dirname(__FILE__) . '/config.php' ;
// REQUEST_METHOD // REQUEST_URI 
require_once dirname(__FILE__) . '/db.php' ;


header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

function mapsql ( $v ) {
	return '`'.$v.'`' ;
} 


function cDateFR ( $date ) {
	if ( strpos( $date , '-' ) !== false )
	return DateTime::createFromFormat('d-m-Y', $date )->format('Y-m-d') ;
	if ( strpos( $date , '/' ) !== false )
	return DateTime::createFromFormat('d/m/Y', $date )->format('Y-m-d') ;
}
		
function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}

class obj  {
// 	var $table = 'runner' ; 
// 	var $defaults = array( 'dos','first', 'last', 'club', 'sex', 'cat' ) ;
// 	var $idAttribute = 'dos' ;
	var $id = false ; 
	var $method = 'GET' ; 
	var $db ;
	var $auto = false ;
	function __construct( $exe = true ) {
		
		if (	! isset( $this -> table ) 
			|| ! isset(  $this -> defaults )
			|| !  isset( $this -> idAttribute ) )
			die ( 'Error :: table ,idAttribute and defaults needed' ) ;
		 
		$self = $_SERVER['PHP_SELF']  ;
		$uri = $_SERVER['REQUEST_URI'] ; 
		$this -> method = $_SERVER['REQUEST_METHOD'] ;
		$uri = explode( '/', $uri  ) ;
		$self = explode( '/', $self ) ;
		if ( count( $uri ) >=  ( count( $self ) )  )
			$this->id = $uri [ count($uri ) -1 ] ;
		else 
			$this->id = false ;  
		// $this -> db = db::getInstance() ; 
		if ( $exe )
		$this->exe () ;
	}
	function getby ( $data ) {  
		$this->defaults = array(  $this->idAttribute  ) ;  
		$where = "where $data->findby = ". json_encode( (string) $data->data,  JSON_UNESCAPED_UNICODE ) . " "  ; 
		$datas = $this -> retrieve( false , $where ) ;  
		return $datas ;
	}
	function checkIn ( $data ) { 

		$idAttribute = $this->idAttribute ;
		$id = $data -> $idAttribute ;

		require_once dirname(__FILE__) . '/user/user.php' ; 

		$this -> join = array (
			  'user' =>  array ( 
					'table' => 'user',
					'as' => 'user' ,
					'join' => 'left' ,
					'attrib' => array( 
						// 'Lname' => 'U_Lname' ,
						// 'Fname' => 'U_Fname' ,
						// 'email' => 'U_email' ,
						// 'code' => 'U_code' , 
					),
					'on' => $this->as . ".checkin_by = user.uid "
			  ),
		) ;
		$user = new user( 0 ) ; 
		$udata = $user -> checkLogin () ;
		$uid = $udata -> uid ; 

		$rdata = $this -> retrieve ( false , " where $this->idAttribute ='$id' " ) ;  

		$date = date('Y-m-d H:i:s', time() - ( 1 * 60 * 60 ) ) ;

		if ( $rdata -> checkin_by == 0 || $rdata -> checkin_by == $uid || date('Y-m-d H:i:s', strtotime( $rdata -> checkin_by ) ) <= $date ) {

			$data = new stdClass() ;
			$idAttribute = $this -> idAttribute ;
			$data -> $idAttribute = $id ;
			$data -> dateCreation = $rdata -> dateCreation ;
			$data -> checkin_by = $uid ; 
			$date = date('Y-m-d H:i:s', time() ) ; 
			$data -> checkin_time = $date ;  
			$data -> _checkin = true ;
			$this -> save( $data, false ) ;
			return ;
		}
		
		$obj = $user -> retrieve ( false , " where $user->idAttribute ='$rdata->checkin_by' " ) ;  
		$obj -> _error = "lockby" ; 
 
		http_response_code(401);
		$this -> output( $obj ) ;
		die() ;

	}

	function checkOut ( $data ) { 
		$idAttribute = $this->idAttribute ;
		$id = $data -> $idAttribute ;

		require_once dirname(__FILE__) . '/user/user.php' ; 

		$this -> join = array (
			  'user' =>  array ( 
					'table' => 'user',
					'as' => 'user' ,
					'join' => 'left' ,
					'attrib' => array( 
						// 'Lname' => 'U_Lname' ,
						// 'Fname' => 'U_Fname' ,
						// 'email' => 'U_email' ,
						// 'code' => 'U_code' , 
					),
					'on' => $this->as . ".checkin_by = user.uid "
			  ),
		) ;
		$user = new user( 0 ) ; 
		$udata = $user -> checkLogin () ;
		$uid = $udata -> uid ; 

		$rdata = $this -> retrieve ( false , " where $this->idAttribute ='$id' " ) ;  

		if ( $rdata -> checkin_by != 0 && $rdata -> checkin_by == $uid ) {

			$data = new stdClass() ;
			$idAttribute = $this -> idAttribute ;
			$data -> $idAttribute = $id ;
			$data -> dateCreation = $rdata -> dateCreation ;
			$data -> checkin_by = 0 ;  
			$data -> checkin_time = '' ;  
			$data -> _checkin = true ;

			$this -> save( $data , false ) ; 
		}
		die('ok') ; 
	}
	function exe ( ) { 
		switch ( $this -> method  ) { 
			case ( 'POST' ) : 
				$data = new stdClass() ; 
				if (! count( $_POST ) ) {
					$this -> method = 'PUT' ;
					return $this->exe() ;
				}
				foreach ( $_POST as $k => $v ) 
					$data -> $k = $v ;   				
				foreach ( $_GET as $k => $v ) 
					if ( ! isset ( $data -> $k ) )
						$data -> $k = $v ;   	
				$data = $this->task ( $data , 'save' ) ;
				$this -> output( $data ) ;
				break ;
			case ( 'PUT' ) :  
				$putdata = fopen("php://input", "r");
				$data = '' ; 
				while ($d = fread($putdata, 1024))
					$data .= $d ;
				$data = json_decode( $data ) ;  						
				foreach ( $_GET as $k => $v ) 
					if ( ! isset ( $data -> $k ) )
						$data -> $k = $v ;   
				$data = $this->task ( $data , 'save' ) ;
				$this -> output( $data ) ;								
				break ;
			case ( 'DELETE' ) : 
				$data = json_decode(json_encode($_GET), FALSE);  
				$data = $this->task ( $data , 'delete' ) ;
				$this -> output( $data ) ;
				break ;
			case ( 'GET' ) :
			default:
				$data = $_GET ; 
				$data = $this->task ( (object)$data , 'retrieve' ) ;
				$this -> output( $data ) ;
		} 
// 		print_r($this) ;
	}

	function task ( $data, $default ) {
		unset( $data -> _status ) ;
		$action = $data->_action ; 
		unset($data->_action ) ;
		$this -> action = $action ;
		if ( method_exists( $this, $action ) ) {
			return $this->$action ( $data )  ;
		} 
		return $this -> $default ( $data ) ; 
	}
	function pager ( $data ) { 
		$limit = " LIMIT ". (int) ( ( $data->page - 1 ) * $data->per_page  ) 
			. " , " . (int)$data->per_page ;
	
		$order = " ORDER BY " . $data -> sortKey . ' '
			. ( $data -> order ? $data -> order : '' ) . ' ' ; 
	
		$datas = $this -> retrieve( true , $where, $order, $limit ) ;

		$db = db::getInstance()  ;
 
		$num = $db -> getNum ( $this->sql ) ; 

		$obj = new stdClass() ;
		$obj -> items = $datas ;
		$obj -> total_count= $num ; 

		return $obj ; 
	}
	function delete ($data ) {
		die() ; 
	}
	function del ( $data ){
		if ( $data -> id  ) {
			$db = db::getInstance()  ;
			$idAttribute = $this -> idAttribute ;
			$sql = "delete from $this->table where $idAttribute ='$data->id' " ;
			if (! $db -> Execute ( $sql ) ) ; 
		}
		return  ; 
	}
	public function savebase64 ( $from , $path , $id , $ext ) { 
		//Get File content from txt file
		$pdf_base64_handler = fopen($from,'rb');
		$pdf_content = stream_get_contents ( $pdf_base64_handler ); 
		fclose ($pdf_base64_handler);
		//Decode pdf content
		$pdf_decoded = $pdf_content;
		// clean 
		$list = scandir( dirname( __FILE__ ) . '/../' . $path ) ; 
		foreach ($list as $l ) {
			$p = explode('.', $l ) ;
				if ( $p[0] == $id ) 
					unlink( dirname( __FILE__ ) . '/../' . $path . $l ) ;
		}
		//path 
		$file = dirname( __FILE__ ) . '/../'.$path . $id . '.' . $ext ; 
		$file = fopen( $file, 'w' ) ;
		fwrite( $file, $pdf_decoded ) ;
		fclose( $file ) ;
	}
	public function copyFile ( $from , $path , $id , $ext ) { 
		// clean 
		$list = scandir( dirname( __FILE__ ) . '/../' . $path ) ; 
		foreach ($list as $l ) {
			$p = explode('.', $l ) ;
				if ( $p[0] == $id ) 
					unlink( dirname( __FILE__ ) . '/../' . $path . $l ) ;
		}
		//path 
		$file = dirname( __FILE__ ) . '/../'.$path . $id . '.' . $ext ; 
		$from = dirname( __FILE__ ) . '/../'.$from ;  
		copy ( $from , $file ) ; 
	}
	public function getlink ( $id , $path ) {
		$link = '' ; 
		$list = scandir( dirname( __FILE__ ) . '/../' . $path ) ; 
		foreach ($list as $l ) {
			$p = explode('.', $l ) ; 
			if ( $p[0] == $id && $l != '..'  && $l != '.'  ) 
				return $path . $l ;
		}
		return '' ;
	}
	public function dellink ( $id , $path ) {
		$list = scandir( dirname( __FILE__ ) . '/../' . $path ) ; 
		foreach ($list as $l ) {
			$p = explode('.', $l ) ;
			if ( $p[0] == $id ) 
				unlink( dirname( __FILE__ ) . '/../' . $path . $l ) ;
		}
	}
	function retrieveSQL ( $where = false ) {
		$sql = "select " .$this->table.'.' . 
			implode(', '.$this->table.'.' , array_map( 'mapsql' ,$this->defaults ) )  ;
		
		if ( is_array($this->join) ) {
			foreach ($this->join as $k => $item) { 
				foreach ($item['attrib'] as $col => $alias) { 
					if (strpos($col,'.') === false)
						$sql .= " , " . $item['as'] .'.`' . $col . '` as `' . $alias . '` ' ;
					else 
						$sql .= " , " .  $col . ' as `' . $alias . '` ' ;
				}
			}
		} 
		$sql .=	" from $this->table  " ;

		if ( is_array($this->join) ) {
			foreach ($this->join as $k => $item) {  
				$sql .= ' '. $item['join'].' JOIN ' . $item['table']. ' as ' . $item['as'] . ' on ( '. $item['on'] . ' ) ' ;
			}
		} 
		$this->sql = $sql ;

		if ( $where ) 
			$sql .= $where ;
		return $sql ;
	}
	function retrieve ( $rows = true ,  $where = false, $order = '' , $limit = '' ) {
		$db = db::getInstance()  ;
		
		$sql = $this -> retrieveSQL ( $where ) ;
		$this -> sql = $sql ; 

		if ( $where && ! $rows ) 
			$result = $db -> getRow ( $sql ) ; 
		elseif ( ! $where && $id = $_GET[ $this -> idAttribute ] )
			$result = $db -> getRow ( $sql . "where $this->idAttribute = '$id' " ) ;
		else 
			$result = $db -> getAll ( $sql . " $order $limit " ) ;
		
		if ( ! $result )
			return '' ; 
		return $result ;
	}
	function save ( $data = null ) { 
		// set dates
		$date = date('Y-m-d H:i:s', time() ) ; 
		if ( ! $data -> dateCreation && ! $data->_checkin )
			$data -> dateCreation = $date ;
		if ( ! isset($data->_import) && ! $data->_checkin )
		$data -> dateModification =  $date ; 

		$db = db::getInstance()  ;
		$keys = $this->defaults ; 
		$idAttribute = $this -> idAttribute ;
		if ( $data -> $idAttribute ) {
			$sql = "select $this->idAttribute from $this->table where $this->idAttribute = '".$data -> $idAttribute."' ";
			$result = $db -> get ( $sql ) ;
			if ( ! $result ) $data -> $idAttribute = 0 ;
		}
		if(($key = array_search( $this->idAttribute , $keys )) !== false) {
			unset($keys[$key]);
			$keys = array_values($keys) ;
		}
		$datas = clone $data ;

		foreach ($data as $k=>$v ) {
			
			if ( ! in_array( $k, $keys ) )
				unset ( $data -> $k ) ; 
			else 
				$data -> $k = ( 
					$v !== NULL ?  json_encode( (string) $v,  JSON_UNESCAPED_UNICODE ) : NULL 
					) ; 
		}
		
		if ( ! $datas->$idAttribute || $datas->$idAttribute == 0 ) {			
			$sql = "insert into $this->table ( " ;
			
			$sql .= implode( ',', array_map( 'mapsql' ,$keys) ) . ' ) values ( ' ;
			foreach ( $keys as $ke => $k ) { 
				if ( $ke ) $sql .= ' , ' ;			
				if ( array_key_exists( $k , $data ) )
					$sql .= ( $data->$k !== NULL ? $data->$k : 'NULL' ) . " " ;
				else 
					$sql .= "''" ;  
			}
			$sql .= ')';  
		}else {
			$sql = "update $this->table set "	; 
			$count = 0 ;
			foreach ( $keys as $ke => $k ) {
				if ( property_exists( $data, $k ) ) {
					if ( $count ) $sql .= ' , ' ;
					if ( array_key_exists( $k , $data ) )
						$sql .= '`'. $k . "` = ".( $data->$k !== NULL ? $data->$k : 'NULL' ) ." " ;
					else
						$sql .= $k . " = ''" ; 
					$count ++ ;
				}
			}
			$sql .= "where $this->idAttribute = '". $datas->$idAttribute . "' " ;
		}

		$data = $datas ;

		// $data -> _sql = $sql ;
		$this -> sql = $sql ;
// print_r( $data ) ;
// die() ;
		if ( $db -> Execute ( $sql ) === true ){
			$data -> _status = 1 ;
		}
		else{
			$data -> _error = $db -> error ;
			$data -> _status = 0 ;
		}
		
		if ( ! $data -> $idAttribute  )
			$data -> $idAttribute = $db -> getInserted()  ; 

		return $data ;
	}
	function output ( $data = '' ) {
		if ( is_object( $data ) )
			// if ( isset( $data-> _action  ) )
			$data-> _action = '' ;
		if ( is_array( $data ) )			
			if ( isset( $data[ '_action' ]  ) )
			$data[ '_action' ] = '' ;
		
		// Respond with a json object 
		$data = json_encode( $data , JSON_UNESCAPED_UNICODE );
		header('content-type: application/json; charset=utf-8');
		if ( $_GET['callback'] )
			echo $_GET['callback'] . '('.$data.')';
		else
			echo $data ;
	}
}
 