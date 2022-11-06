<?php 

class User
{
	private $_db,
			$_data,
			$_sessionName,
			$_cookieName,
			$_isLoggedIn = false,
			$user_info
	;

	public function __construct($user = null) {
		$this->_db = DB::connect();
		$this->_sessionName = Config::get('session.session_name');
		$this->_cookieName = Config::get('remember.cookie_name');

		if (!$user) {
			if (Session::exists($this->_sessionName)) {
				$user = Session::get($this->_sessionName);
				if ($this->find($user)) {
					$this->_isLoggedIn = true;
				}else {

				}
			}
		}else {
			$this->find($user);
			$this->find_by_username($user);

		}
	}


	public function update($fields = array(), $id = null) {

		if (!$id && $this->isLoggedIn()) {
			$id = $this->data()->id;
		}

		if (!$this->_db->update('users', $id, $fields)) {
			throw new Exception("Error Processing Update Request.");
		}
	}


	public function create($fields = array()) {
		if (!$this->_db->insert('users', $fields)) {
			throw new Exception("Error Processing Request.");
			
		}
	}

	public function find($user = null) {
		if ($user) {
			$field = is_numeric($user) ? 'id' : 'email';
			$data = $this->_db->select('users', array($field, '=', $user));
			if ($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function find_by_username($user = null) {
		if ($user) {
			$field = is_numeric($user) ? 'id' : 'username';
			$data = $this->_db->select('users', array($field, '=', $user));
			if ($data->count()) {
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function find_info($id) {
		$data = $this->_db->select('additional_user_info', array('user_id', '=', $id));
		if ($data->count()) {
			$this->user_info = $data->first();
			return true;
		}else {
			return false;
		}
	}


	public function user_info() {
		return $this->user_info;
	}

	public function login($email = null, $password = null, $remember = false) {
		if (!$email && !$password && $this->exists()) {
			Session::put($this->_sessionName, $this->data()->id);
		}else {

			$user = $this->find($email);

			if ($user) {
				if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
					Session::put($this->_sessionName, $this->data()->id);
					if ($remember) {
						$hash = Hash::unique();
						$hash_check = $this->_db->select('users_session', array('user_id', '=', $this->data()->id));

						if (!$hash_check->count()) {
							$this->_db->insert('users_session', array(
								'user_id' => $this->data()->id,
								'hash' => $hash
							));
						}else {
							$hash = $hash_check->first()->hash;
						}

						Cookie::put($this->_cookieName, $hash, Config::get('remember.cookie_expiry'));

					}
					return true;
				}
			}
		}
		return false;	
	}

	public function logout() {
		$this->_db->delete('users_session', array('user_id', '=', $this->data()->id));

		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
	}


	public function hasPermission($key) {
		$group = $this->_db->select('groups', array('id', '=', $this->data()->groups));
		if ($group->count()) {
			$permissions = json_decode($group->first()->permissions, true);
			if ($permissions[$key] == true) {
				return true;
			}
		}

		return false;
	}

	public function exists() {
		return (!empty($this->_data)) ? true : false;
	}


	public function data() {
		return $this->_data;
	}

	public function isLoggedIn() {
		return $this->_isLoggedIn;
	}
}