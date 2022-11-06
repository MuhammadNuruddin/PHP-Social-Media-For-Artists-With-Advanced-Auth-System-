<?php 

class Validate 
{
	private $_passed = false,
			$_errors = array(),
			$_db = null;



	public function __construct() {
		$this->_db = DB::connect();
	}

	public function check($source, $items) {
		foreach ($items as $item => $rules) {
			foreach ($rules as $rule => $rule_value) {
				// echo "".$rules['field_name']." {$rule} must be {$rule_value}</br>";
				$value = trim($source[$item]);
				$item = escape($item);
				if ($rule === 'required' && empty($value)) {
					$this->addError("".$rules['field_name']." is required");
				}else if(!empty($rule)) {
					switch ($rule) {
						case 'min':
							if (strlen($value) < $rule_value) {
								$this->addError("".$rules['field_name']." must be a minimum of {$rule_value} characters");
							}
							break;
						case 'max':
							if (strlen($value) > $rule_value) {
								$this->addError("".$rules['field_name']." must be a maximum of {$rule_value} characters");
							}
							break;
						case 'matches':
							if ($value != $source[$rule_value]) {
								$this->addError("".$rules['field_name']." must match");
							}
							break;	
						case 'unique':
							$check = $this->_db->select($rule_value, array($item,'=',$value));
							if ($check->count()) {
								$this->addError("{$rules['field_name']} already exist");
							}
							break;	
						case 'pattern':
							if($rule_value == 'email') {
								if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
									$this->addError("Invalid Email Address...");
								}
							}else if($rule_value == 'username') {
								if(!preg_match('/^[a-z\d]{3,30}$/i', $value)) {
									$this->addError("Username format not valid");
								}
							}
							
							break;
					}
				}
			}
		}

		if (empty($this->_errors)) {
			$this->_passed = true;
		}
		return $this;
	}


	private function addError($error) {
		$this->_errors[] = $error;
	}

	public function errors() {
		return $this->_errors;
	}

	public function passed() {
		return $this->_passed;
	}
}