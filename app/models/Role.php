<?php

namespace Model;

/**
 * roles model
 */
class Role extends Model
{

	public $errors = [];
	protected $table = "roles";

	protected $afterSelect = [

		'get_permissions'
	];

	protected $allowedColumns = [

		'role',
		'disabled',

	];

	public function validate($data)
	{
		$this->errors = [];

		if (empty($data['role'])) {
			$this->errors['role'] = "A role is required";
		} else
		if (!preg_match("/^[a-zA-Z \&\']+$/", trim($data['role']))) {
			$this->errors['role'] = "role can only have letters and spaces or &";
		}

		if (empty($this->errors)) {
			return true;
		}

		return false;
	}

	protected function get_permissions($data)
	{

		if (!empty($data[0]->id) && !empty($data[0]->role)) {

			foreach ($data as $key => $row) {

				$query = "select permission from permissions_map where role_id = :role_id && disabled = 0";
				$res = $this->query($query, ['role_id' => $row->id]);

				if ($res) {
					$data[$key]->permissions = array_column($res, 'permission');
				}
			}
		}

		return $data;
	}
}
