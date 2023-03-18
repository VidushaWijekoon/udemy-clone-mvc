<?php

namespace Controller;

/**
 * login class
 */

use Model\Auth;
use Model\User;

class Login extends Controller
{

	public function index()
	{

		$data['errors'] = [];

		$data['title'] = "Login";
		$user = new User();

		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			//validate
			$row = $user->first([
				'email' => $_POST['email']
			]);

			if ($row) {

				if (password_verify($_POST['password'], $row->password)) {
					//get user role name
					$query = "select role from roles where id = :id limit 1";
					$id = $row->role;

					$role = $user->query($query, ['id' => $id]);
					if ($role) {
						$row->role_name = $role[0]->role;
					} else {
						$row->role_name = '';
					}

					//authenticate
					Auth::authenticate($row);

					redirect('home');
				}
			}

			$data['errors']['email'] = "Wrong email or password";
		}

		$this->view('login', $data);
	}
}
