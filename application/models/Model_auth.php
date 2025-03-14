<?php 

class Model_auth extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/* 
		This function checks if the email exists in the database
	*/
	public function check_email($email) 
	{
		if($email) {
			$sql = 'SELECT * FROM users WHERE email = ?';
			$query = $this->db->query($sql, array($email));
			$result = $query->num_rows();
			return ($result == 1) ? true : false;
		}

		return false;
	}

	/* 
		This function checks if the email and password matches with the database
	*/
	public function login($email, $password) {
		if($email && $password) {
			$sql = "SELECT u.*, mb.br_name as factory_name 
            FROM users u
            LEFT JOIN mbranchlist mb ON mb.id = u.factory_id 
            WHERE email = ?";
			$query = $this->db->query($sql, array($email));
			$row = $query->row_array();

			if($query->num_rows() == 1) {
				$result = $query->row_array();

				$hash_password = password_verify($password, $result['password']);
				if($hash_password === true) {
				if(isset($_POST['token'])){
					$sql = "DELETE FROM `fcm_token` WHERE user_id = ".$result['id']." AND token = '".$_POST['token']."'";
					$this->db->query($sql);
					$this->db->insert(' fcm_token',['user_id'=>$result['id'],'token'=>$_POST['token']]);
					}
					return $result;	
				}
				else {
					return false;
				}

				
			}
			else {
				return false;
			}
		}
	}
}