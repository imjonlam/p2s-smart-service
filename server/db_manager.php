<?php

include 'init_conn.php';

class db_manager {
	private $conn;
    private $stmt;
    private $error = '';
	
	function __construct($sn="localhost", $u="root", $p="", $db='cps630_proj_db') {		
		$init = new init_conn($sn, $u, $p, $db);
		$this->conn = $init->createConn();
	}
	
	function select($tbl, $arr) {
		list($query, $a) = $this->parseStatement('select', $tbl, $arr);
        $result = $this->prepareStatement($query, $tbl, $a);
        return $result ? $this->stmt->get_result() : $result;
	}
	
	function update($tbl, $arr) {
		list($query, $a) = $this->parseStatement('update', $tbl, $arr);
		return $this->prepareStatement($query, $tbl, $a);
	}
	
	function insert($tbl, $arr) {
		list($query, $a) = $this->parseStatement('insert', $tbl, $arr);
		return $this->prepareStatement($query, $tbl, $a);
	}
	
	function delete($tbl, $arr) {
		list($query, $a) = $this->parseStatement('delete', $tbl, $arr);
		return $this->prepareStatement($query, $tbl, $a);
	}
	
	function error() {
		return ($this->stmt !== '') ? $this->stmt->error : $this->conn->error;
	}
  
	function getInsertId() {
		return $this->conn->insert_id;
	}
	
	private function parseStatement($type, $table, $arr) {
		$query = '';
		$inds = [];
		$col = [];
        $a = [];
		switch ($table) {
			case 'Users':
				$inds = ['id', 'username', 'password', 'email', 'name', 'phone', 'role', 'city', 'salt', 'bal'];
				$col = ['id'=>'id', 'username'=>'login_id', 'password'=>'password', 'email'=>'email', 'name'=>'name', 'phone'=>'telephone', 'role'=>'role', 'city'=>'city', 'salt'=>'salt', 'bal'=>'balance'];
				break;
			case 'Cars':
				$inds = ['id', 'vin', 'model', 'desc', 'price', 'logo', 'avail'];
				$col = ['id'=>'id', 'vin'=>'car_code', 'model'=>'model', 'desc'=>'description', 'price'=>'price', 'logo'=>'image', 'avail'=>'available'];
				break;
			case 'Flowers':
				$inds = ['id', 'name', 'store', 'price', 'logo'];
				$col = ['id'=>'id', 'name'=>'name', 'store'=>'store_code', 'price'=>'price', 'logo'=>'image'];
				break;
			case 'Coffees':
				$inds = ['id', 'name', 'store', 'price', 'logo'];
				$col = ['id'=>'id', 'name'=>'name', 'store'=>'store_code', 'price'=>'price', 'logo'=>'image'];
				break;
			case 'Shops':
				$inds = ['id', 'name', 'category', 'address', 'logo'];
				$col = ['id'=>'id', 'name'=> 'name', 'category' => 'category', 'address'=>'address', 'logo'=>'image'];
				break;
			case 'Trips':
				$inds = ['id', 'source', 'dest', 'dist', 'city', 'car', 'price'];
				$col = ['id'=>'id', 'source'=>'origin', 'dest'=>'destination', 'dist'=>'distance', 'city'=>'city', 'car'=>'car_id', 'price'=>'price'];
				break;
			case 'Orders':
				$inds = ['id', 'iss', 'done', 'desc', 'price', 'pay_code', 'user', 'trip', 'flower', 'coffee', 'car', 'reviewed'];
				$col = ['id'=>'order_number', 'iss'=>'issued_date', 'done'=>'done_date', 'desc'=>'description', 'price'=>'total_price', 'pay_code'=>'payment_code', 'user'=>'user_id', 'trip'=>'trip_id', 'flower'=>'flower_id', 'coffee'=>'coffee_id', 'car'=>'car_id', 'reviewed'=>'reviewed'];
				break;
			case 'Reviews':
				$inds = ['id', 'order_number', 'desc', 'rating'];
				$col = ['id'=>'id', 'order_number'=>'order_number', 'desc'=> 'description', 'rating'=>'rating'];
				break;
			case 'Suggestions':
				$inds = ['id', 'business', 'address'];
				$col = ['id'=>'id', 'business'=>'business', 'address'=>'address'];
				break;
		}
		switch ($type) {
			case 'select':
				if ($table == "Users")
					$query = "SELECT `id`, `name`, `telephone`, `email`, `city`, `login_id`, `password`, `salt`,FROM_BASE64(`balance`) as `balance`, `role` FROM `users`";
				else
					$query = "SELECT * FROM `$table`";
				$and=0;
				foreach ($inds as $ind) {
					if (isset($arr[$ind]) && !empty($arr[$ind])) {
						if($and == 1) {
							$query .= " AND ";
						}
						else {
							$query .= " WHERE ";
							$and = 1;
						}
						if ($ind == 'password')
							$query .= "`{$col[$ind]}`=SHA(?)";
						else
							$query .= "`{$col[$ind]}`=?";
                        $a[$ind] = $arr[$ind];
					}
				}
				break;
			case 'insert':
				$query = "INSERT INTO `$table` (";
				$b = ") VALUES (";
				$and=0;
				foreach ($inds as $ind) {
					if (isset($arr[$ind])) {
						if($and == 1) {
							$query .= ", ";
							$b .= ", ";
						}
						else 
							$and = 1;
						
						$query .= "`{$col[$ind]}`";
                        if (empty($arr[$ind]))
                          $b .= "NULL";
						elseif ($ind == 'password')
							$b .= "SHA(?)";
						elseif ($ind == 'bal')
							$b .= "TO_BASE64(?)";
						else
							$b .= "?";
                        if (!empty($arr[$ind]))
                          $a[$ind] = $arr[$ind];
					}
				}
				$query .= $b . ")";
				break;
			case 'update':
				$query = "UPDATE `$table` SET ";
				$and=0;
				foreach ($inds as $ind) {
					if (isset($arr[$ind]) && $ind !== 'id' ) {
						if($and == 1) 
							$query .= ", ";
						else 
							$and = 1;
						
						if ($ind == 'password')
							$query .= "`{$col[$ind]}`=SHA(?)";
						elseif ($ind == 'bal')
							$query .= "`{$col[$ind]}`=TO_BASE64(?)";
						else
							$query .= "`{$col[$ind]}`=?";
                        $a[$ind] = $arr[$ind];
					}
				}
				$query .= " WHERE `{$col['id']}`=?";
                $a['id'] = $arr['id'];
				break;
			case 'delete':
				$query = "DELETE FROM `$table` WHERE `{$col['id']}`=?";
                $a['id'] = $arr['id'];
				break;
		}
      
		return array($query, $a);
	}
  
    private function prepareStatement($query, $table, $a) {
		$types = [];        
		switch ($table) {
			case 'Users':
				$types = ['id'=>'i', 'username'=>'s', 'password'=>'s', 'email'=>'s', 'name'=>'s', 'phone'=>'i', 'role'=>'s', 'city'=>'s', 'salt'=>'s', 'bal'=>'s'];
				break;
			case 'Cars':
				$types = ['id'=>'i', 'vin'=>'s', 'model'=>'s', 'desc'=>'s', 'price'=>'d', 'logo'=>'s', 'avail'=>'i'];
				break;
			case 'Flowers':
				$types = ['id'=>'i', 'name'=>'s', 'store'=>'i', 'price'=>'d', 'logo'=>'s'];
				break;
			case 'Coffees':
				$types = ['id'=>'i', 'name'=>'s', 'store'=>'i', 'price'=>'d', 'logo'=>'s'];
				break;
			case 'Shops':
				$types = ['id'=>'i', 'name'=> 's', 'category' => 's', 'address'=>'s', 'logo'=>'s'];
				break;
			case 'Trips':
				$types = ['id'=>'i', 'source'=>'s', 'dest'=>'s', 'dist'=>'d', 'city'=>'s', 'car'=>'i', 'price'=>'d'];
				break;
			case 'Orders':
				$types = ['id'=>'i', 'iss'=>'s', 'done'=>'s', 'desc'=>'s', 'price'=>'d', 'pay_code'=>'s', 'user'=>'i', 'trip'=>'i', 'flower'=>'i', 'coffee'=>'i', 'car'=>'i', 'reviewed'=>'s'];
				break;
			case 'Reviews':
				$types = ['id'=>'i', 'order_number'=>'i', 'desc'=> 's', 'rating'=>'i'];
				break;
			case 'Suggestions':
				$types = ['id'=>'i', 'business'=>'s', 'address'=>'s'];
				break;
		}
        $t = '';
        foreach (array_keys($a) as $ind) {
            $t .= $types[$ind];
        }
        $this->stmt = $this->conn->prepare($query);
        if (strlen($t) > 0)
          $this->stmt->bind_param($t, ...array_values($a));
        return $this->stmt->execute();
    }
 }
?>