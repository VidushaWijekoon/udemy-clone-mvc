<?php

namespace Model;

/**
 * course lecture model
 */
class Course_lecture extends Model
{

	public $errors = [];
	protected $table = "courses_lectures";

	protected $allowedColumns = [

		'title',
		'uid',
		'file',
		'description',
		'disabled',

	];

	public function validate($data)
	{
		$this->errors = [];

		if (empty($data['currency'])) {
			$this->errors['currency'] = "A currency is required";
		}

		if (empty($data['symbol'])) {
			$this->errors['symbol'] = "A currency symbol is required";
		}



		if (empty($this->errors)) {
			return true;
		}

		return false;
	}
}
