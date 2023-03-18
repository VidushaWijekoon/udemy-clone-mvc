<?php

namespace Controller;

if (!defined("ROOT")) die("direct script access denied");

/**
 * category class
 */

class Category extends Controller
{

	public function index($slug = null)
	{

		$course = new \Model\Course();
		$category = new \Model\Category();

		$data['title'] = "Category";

		//red all courses 
		$query = "SELECT c.*,cat.category,cat.slug as catslug FROM courses as c join categories as cat on cat.id = c.category_id where cat.slug = :slug";
		$data['rows'] = $course->query($query, ['slug' => $slug]);

		//red all courses order by trending value
		$query = "select * from courses where approved = 0 order by trending desc limit 5";
		$data['trending'] = $course->query($query);

		if ($data['rows']) {
			$data['first_row'] = $data['rows'][0];
			unset($data['rows'][0]);

			$total_rows = count($data['rows']);
			$half_rows = round($total_rows / 2);

			$data['rows1'] = array_splice($data['rows'], 0, $half_rows);
			$data['rows2'] = $data['rows'];
		}


		$this->view('category', $data);
	}
}
