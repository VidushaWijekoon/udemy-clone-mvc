<?php

namespace Model;

/**
 * slider model
 */
class Slider extends Model
{

	public $errors = [];
	protected $table = "slider_images";

	protected $allowedColumns = [

		'id',
		'image',
		'title',
		'description',
		'disabled',

	];

	public function validate($data)
	{
		$this->errors = [];

		if (empty($data['title'])) {
			$this->errors['title'] = "A title is required";
		}

		if (empty($data['description'])) {
			$this->errors['description'] = "A description is required";
		}

		if (empty($data['image'])) {
			$this->errors['image'] = "An image is required";
		}



		if (empty($this->errors)) {
			return true;
		}

		return false;
	}
}
