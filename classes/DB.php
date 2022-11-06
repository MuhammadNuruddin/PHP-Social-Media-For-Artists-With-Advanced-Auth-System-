<?php 


class DB 
{
	private static $_insatance = null;
	private $_pdo,
			$_query,
			$_error = false,
			$_results,
			$row_count = 0,
			$results,
			$_count = 0;


	// public static $length = $this->row_count;
	private function __construct() {
		try {
			$this->_pdo = new PDO('mysql:host='.Config::get('mysql.host').';dbname='.Config::get('mysql.db'), Config::get('mysql.username'), Config::get('mysql.password'));
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}


	public static function connect() {
		if (!isset(self::$_insatance)) {
			self::$_insatance = new DB;
		}
		return self::$_insatance;
	}


	public function query($sql, $params = array()) {
		$this->_error = false;
		if ($this->_query = $this->_pdo->prepare($sql)) {
			$x = 1;
			if (count($params)) {
				foreach ($params as $param) {
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}
			if ($this->_query->execute()) {
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
			}else {
				$this->_error = true;
			}
		}

		return $this;
	}


	public function action($action, $table, $where = array()){
		if (count($where) === 3) {
			$operators = array('<','>','=','>=','<=');

			$field = $where[0];
			$operator = $where[1];
			$value = $where[2];


			if (in_array($operator, $operators)) {
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

				if (!$this->query($sql,array($value))->error()) {
					return $this;
				}
			}
		}

		return false;
	}


	public function pdo_query($action, $table, $operator, $fields = array(), $values = array()){
		// if (count($where) === 3) {
			$operators = array('<','>','=','>=','<=');

			// $field = $where[0];
			$operator = $operator;
			// $value = $where[2];


			if (in_array($operator, $operators)) {
				$sql = "{$action} FROM {$table} WHERE {$fields[0]} {$operator} :{$fields[0]} && {$fields[1]} {$operator} :{$fields[1]}";
				$stmt = $this->_pdo->prepare($sql);
				$stmt->execute(
					[''.$fields[0].'' => $values[0], ''.$fields[1].'' => $values[1]]);
				$this->row_count = $stmt->rowCount();
			$this->results = $stmt->fetchAll(PDO::FETCH_OBJ);
			return $this;
				// return $sql;
				
				// if (!$this->query($sql,array($value))->error()) {
				// 	return $sql;
				// }
			}
		// }
		// return false;
	}

	// public function action_test($action, $table, $operator, $fields = array() , $values = array()){
	// 	// if (count($where) === 3) {
	// 		$operators = array('<','>','=','>=','<=');

	// 		// $field = $where[0];
	// 		// $operator = $where[1];
	// 		// $value = $where[2];


	// 		if (in_array($operator, $operators)) {
	// 			$sql = "{$action} FROM {$table} WHERE {$field[0]} {$operator} {$values[0]} AND {$field[1]} {$operator} {$values[1]}?";

	// 			if (!$this->query($sql,array($value))->error()) {
	// 				return $this;
	// 			}
	// 		}
	// 	// }

	// 	return false;
	// }
	// public function select_test($table, $operator, $fields, $values){
	// 	return $this->action_test('SELECT *',$table,$operator,$fields,$values);
	// }

	// public function delete_test($table, $operator, $fields, $values){
	// 	return $this->action_test('DELETE',$table,$operator,$fields,$values);
	// }
	public function pdo_results() {
		return $this->results;
	}
	public function pdo_row_count() {
		return $this->row_count;
	}
	public function pdo_select($table, $operator, $fields = array(), $values = array()) {
		return $this->pdo_query("SELECT *",$table,$operator,$fields,$values);
	}
	public function pdo_delete($table, $operator, $fields = array(), $values = array()) {
		return $this->pdo_query("DELETE",$table,$operator,$fields,$values);
	}
	public static function length() {
		return $this->row_count;
	}
	public function select($table, $where){
		return $this->action('SELECT *',$table,$where);
	}

	public function delete($table, $where) {
		return $this->action('DELETE',$table,$where);

	}

	public function insert($table, $fields = array()) {
		if (count($fields)) {
			$keys = array_keys($fields);
			$values = '';
			$x = 1;

			foreach ($fields as $field) {
				$values .= '?';
				if ($x < count($fields)) {
					$values .= ', ';
				}
				$x++;
			}


			$sql = "INSERT INTO {$table} (`".implode('`,`', $keys)."`) VALUES({$values})";
			if (!$this->query($sql,$fields)->error()) {
				return true;
			}
		}
		return false;
	}

	public function update($table,$id,$fields = array()) {
		$set = '';
		$x = 1;

		foreach ($fields as $name => $value) {
			$set .= "{$name} = ?";
			if ($x < count($fields)) {
				$set .= ', ';
			}
			$x++;
		}
		

		$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";
		if (!$this->query($sql,$fields)->error()) {
			return true;
		}
		
		return false;
	}

	public function update_reaction($table,$id,$fields = array()) {
		$set = '';
		$x = 1;

		foreach ($fields as $name => $value) {
			$set .= "{$name} = ?";
			if ($x < count($fields)) {
				$set .= ', ';
			}
			$x++;
		}
		

		$sql = "UPDATE {$table} SET {$set} WHERE work_id = {$id}";
		if (!$this->query($sql,$fields)->error()) {
			return true;
		}
		
		return false;
	}

	public function update_additional_info($table,$id,$fields = array()) {
		$set = '';
		$x = 1;

		foreach ($fields as $name => $value) {
			$set .= "{$name} = ?";
			if ($x < count($fields)) {
				$set .= ', ';
			}
			$x++;
		}
		

		$sql = "UPDATE {$table} SET {$set} WHERE user_id = {$id}";
		if (!$this->query($sql,$fields)->error()) {
			return true;
		}
		
		return false;
	}

	public function results(){
		return $this->_results;
	}

	public function first() {
		return $this->results()[0];
	}

	public function error() {
		return $this->_error;
	}


	public function count() {
		return $this->_count;
	}
}