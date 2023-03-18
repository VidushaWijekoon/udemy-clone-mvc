<?php

namespace Model;

/**
 * course meta model
 */
class Course_meta extends Model
{

	public $errors = [];
	protected $table = "courses_meta";

	protected $allowedColumns = [

		'course_id',
		'tab',
		'uid',
		'data_type',
		'value',
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
