<?php

namespace Controller;

/**
 * admin class
 */

use \Model\Auth;
use \Model\Slider;

class Admin extends Controller
{

	public function index()
	{

		if (!Auth::logged_in()) {
			message('please login to view the admin section');
			redirect('login');
		}

		$data['title'] = "Page not found";

		$this->view('admin/404', $data);
	}

	public function dashboard()
	{

		if (!Auth::logged_in()) {
			message('please login to view the admin section');
			redirect('login');
		}

		$data['title'] = "Dashboard";

		$this->view('admin/dashboard', $data);
	}

	public function courses($action = null, $id = null)
	{

		if (!Auth::logged_in()) {
			message('please login to view the admin section');
			redirect('login');
		}

		$user_id = Auth::getId();
		$course = new \Model\Course();
		$category = new \Model\Category();
		$language = new \Model\Language_model();
		$level = new \Model\Level_model();
		$price = new \Model\Price_model();
		$currency = new \Model\Currency_model();

		$data = [];
		$data['action'] = $action;
		$data['id'] = $id;

		if ($action == 'add') {

			$data['categories'] = $category->findAll('asc');

			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				if ($course->validate($_POST)) {

					$_POST['date'] = date("Y-m-d H:i:s");
					$_POST['user_id'] = $user_id;
					$_POST['price_id'] = 1;

					$course->insert($_POST);

					$row = $course->first(['user_id' => $user_id, 'published' => 0]);
					message("Your Course was successfuly created");

					if ($row) {
						redirect('admin/courses/edit/' . $row->id);
					} else {
						redirect('admin/courses');
					}
				}

				$data['errors'] = $course->errors;
			}
		} elseif ($action == 'delete') {

			$categories = $category->findAll('asc');
			$languages = $language->findAll('asc');
			$levels = $level->findAll('asc');
			$prices = $price->findAll('asc');
			$currencies = $currency->findAll('asc');

			//get course information
			$data['row'] = $row = $course->first(['user_id' => $user_id, 'id' => $id]);

			if ($_SERVER['REQUEST_METHOD'] == "POST" && $row) {

				$course->delete($row->id);
				message("Course deleted successfully");
				redirect('admin/courses');
			}
		} elseif ($action == 'edit') {

			$categories = $category->findAll('asc');
			$languages = $language->findAll('asc');
			$levels = $level->findAll('asc');
			$prices = $price->findAll('asc');
			$currencies = $currency->findAll('asc');

			//get course information
			$data['row'] = $row = $course->first(['user_id' => $user_id, 'id' => $id]);

			if ($_SERVER['REQUEST_METHOD'] == "POST" && $row) {


				if (!empty($_POST['data_type']) && $_POST['data_type'] == "read") {
					if ($_POST['tab_name'] == "course-landing-page") {

						include views_path('course-edit-tabs/course-landing-page');
					} else
						if ($_POST['tab_name'] == "course-messages") {

						include views_path('course-edit-tabs/course-messages');
					} else
						if ($_POST['tab_name'] == "intended-learners") {

						include views_path('course-edit-tabs/intended-learners');
					} else
						if ($_POST['tab_name'] == "curriculum") {

						include views_path('course-edit-tabs/curriculum');
					}
				} else
					if (!empty($_POST['data_type']) && $_POST['data_type'] == "get-meta") {

					//get meta data for inputs on the tab
					$course_meta = new \Model\Course_meta();

					$rows = $course_meta->where(['course_id' => $_POST['course_id'], 'disabled' => 0]);

					$info['data'] = [];
					if ($rows) {
						$course_lecture = new \Model\Course_lecture;
						foreach ($rows as $akey => $course_meta_row) {

							$row_lectures = $course_lecture->where(['uid' => $course_meta_row->uid, 'disabled' => 0]);

							if ($row_lectures) {
								foreach ($row_lectures as $zkey => $zrow) {
									$row_lectures[$zkey]->base_file = $zrow->file;
									$row_lectures[$zkey]->file = get_video($zrow->file);
								}

								$rows[$akey]->lectures = $row_lectures;
							}
						}

						$info['data'] = $rows;
					}
					$info['data_type'] = "get-meta";

					echo json_encode($info);
				} else
					if (!empty($_POST['data_type']) && $_POST['data_type'] == "save") {

					//check if form is valid
					if ($_SESSION['csrf_code'] == $_POST['csrf_code']) {

						if ($course->edit_validate($_POST, $id, $_POST['tab_name'])) {

							if ($_POST['tab_name'] == "intended-learners") {

								$course_meta = new \Model\Course_meta();

								$meta_data = [];
								foreach ($_POST as $key => $value) {

									if (!empty($value) && preg_match("/^[a-zA-Z\-]+_[0-9]+$/", $key)) {
										$key = preg_replace("/_[0-9]+$/", "", $key);
										$meta_data[$key][] = $value;
									}
								}

								//disabled all records from this course id
								$old_records = $course_meta->where(['course_id' => $id, 'tab' => $_POST['tab_name']]);
								$old_ids = [];
								if ($old_records) {
									$old_ids = array_column($old_records, 'id');

									foreach ($old_records as $record) {

										$course_meta->update($record->id, ['disabled' => 1]);
									}
								}

								if (!empty($meta_data)) {
									foreach ($meta_data as $key => $rows) {

										$data_type = $key;
										foreach ($rows as $value) {

											$arr = [];
											$arr['data_type'] 	= $data_type;
											$arr['course_id'] 	= $id;
											$arr['value'] 		= $value;
											$arr['disabled'] 	= 0;
											$arr['tab'] 		= $_POST['tab_name'];
											$arr['uid'] 		= $_POST['uid'];

											if (count($old_ids) > 0) {
												$my_old_id = array_pop($old_ids);
												$course_meta->update($my_old_id, $arr);
											} else {

												$arr['uid'] = time() . rand(100, 999);

												while ($course_meta->where(['uid' => $arr['uid']])) {
													$arr['uid'] = time() . rand(100, 999);
												}

												$course_meta->insert($arr);
											}
										}
									}
								}

								$info['data'] = "Course saved successfully";
								$info['data_type'] = "save";
							} else
								if ($_POST['tab_name'] == "curriculum") {

								$course_meta = new \Model\Course_meta();
								$course_lecture = new \Model\Course_lecture;

								$meta_data = [];
								$meta_data_uids = [];
								$meta_data_descriptions = [];
								$meta_data_index = [];

								$lecture_data = [];
								$lecture_data_uids = [];
								$lecture_data_descriptions = [];
								$lecture_data_files = [];
								$lecture_data_new_files = [];
								$lecture_data_index = [];

								foreach ($_POST as $key => $value) {

									/** for sections **/
									if (!empty($value) && preg_match("/^curriculum_[0-9]+$/", $key)) {
										$mainkey = preg_replace("/_[0-9]+$/", "", $key);
										$subkey = preg_replace("/^curriculum_/", "", $key);
										$meta_data[$mainkey][$subkey] = $value;
									} else

										if (!empty($value) && preg_match("/^uid_curriculum_[0-9]+$/", $key)) {
										$mainkey = preg_replace("/_[0-9]+$/", "", $key);
										$subkey = preg_replace("/^uid_curriculum_/", "", $key);
										$meta_data_uids[$mainkey][$subkey] = $value;
									} else

										if (!empty($value) && preg_match("/^description_curriculum_[0-9]+$/", $key)) {
										$mainkey = preg_replace("/_[0-9]+$/", "", $key);
										$subkey = preg_replace("/^description_curriculum_/", "", $key);
										$meta_data_descriptions[$mainkey][$subkey] = $value;
									}

									/** for lectures **/
									if (preg_match("/^lecture_[0-9]+_curriculum_[0-9]+$/", $key)) {
										$key = preg_replace("/^lecture_[0-9]+_curriculum_/", "", $key);
										$lecture_data[$key][] = $value;
									}

									if (preg_match("/^description_lecture_[0-9]+_curriculum_[0-9]+$/", $key)) {
										$key = preg_replace("/^description_lecture_[0-9]+_curriculum_/", "", $key);
										$lecture_data_descriptions[$key][] = $value;
									}

									if (preg_match("/^file_lecture_[0-9]+_curriculum_[0-9]+$/", $key)) {
										$key = preg_replace("/^file_lecture_[0-9]+_curriculum_/", "", $key);
										$lecture_data_files[$key][] = $value;
									}
								}

								//check for video files
								foreach ($_FILES as $key => $file) {

									if (preg_match("/^new_file_lecture_[0-9]+_curriculum_[0-9]+$/", $key)) {
										$filename = "";
										$folder = "uploads/courses/";
										if (!file_exists($folder)) {
											mkdir($folder, 0777, true);
										}

										if (!empty($file[$key]['name'])) {
											$filename = $folder . time() . $file[$key]['name'];
											move_uploaded_file($file[$key]['tmp_name'], $filename);
										}
										$key = preg_replace("/^new_file_lecture_[0-9]+_curriculum_/", "", $key);
										$lecture_data_new_files[$key][] = $filename;
									}
								}


								//disabled all records from this course id
								$old_records = $course_meta->where(['course_id' => $id, 'tab' => $_POST['tab_name']]);
								$old_ids = [];
								if ($old_records) {
									$old_ids = array_column($old_records, 'id');

									foreach ($old_records as $record) {

										$course_meta->update($record->id, ['disabled' => 1]);
									}
								}


								if (!empty($meta_data)) {

									foreach ($meta_data as $key => $rows) {

										$data_type = $key;

										foreach ($rows as $key2 => $value) {

											$arr = [];
											$arr['data_type'] 	= $data_type;
											$arr['course_id'] 	= $id;
											$arr['value'] 		= $value;
											$arr['disabled'] 	= 0;
											$arr['tab'] 		= $_POST['tab_name'];

											if (!empty($meta_data_uids['uid_' . $key][$key2]))
												$arr['uid'] 		= $meta_data_uids['uid_' . $key][$key2];

											if (!empty($meta_data_descriptions['description_' . $key][$key2]))
												$arr['description'] = $meta_data_descriptions['description_' . $key][$key2];


											if (count($old_ids) > 0) {
												$my_old_id = array_pop($old_ids);
												$course_meta->update($my_old_id, $arr);
											} else {

												$arr['uid'] = time() . rand(100, 999);

												while ($course_meta->where(['uid' => $arr['uid']])) {
													$arr['uid'] = time() . rand(100, 999);
												}

												$course_meta->insert($arr);
											}

											/** save to lectures table **/
											if (!empty($lecture_data[$key2])) {

												$myuid = $arr['uid'];

												//disabled all records from this course lectures table
												$old_lecture_records = $course_lecture->where(['uid' => $myuid]);
												$old_lecture_ids = [];
												if ($old_lecture_records) {
													$old_lecture_ids = array_column($old_lecture_records, 'id');

													foreach ($old_lecture_records as $record) {

														$course_lecture->update($record->id, ['disabled' => 1]);
													}
												}


												foreach ($lecture_data[$key2] as $key3 => $lec_title) {

													$arr = [];
													$arr['uid'] = $myuid;
													$arr['disabled'] = 0;
													$arr['title'] = $lec_title;
													$arr['description'] = $lecture_data_descriptions[$key2][$key3] ?? "";
													$arr['file'] = $lecture_data_new_files[$key2][$key3] ?? "";

													if (empty($arr['file']))
														$arr['file'] = $lecture_data_files[$key2][$key3] ?? "";

													if (count($old_lecture_ids) > 0) {
														$my_old_lecture_id = array_pop($old_lecture_ids);
														$course_lecture->update($my_old_lecture_id, $arr);
													} else {

														$course_lecture->insert($arr);
													}
												}
											}
										}
									}
								}

								$info['data'] = "Course saved successfully";
								$info['data_type'] = "save";
							} else
								if ($_POST['tab_name'] == "course-landing-page") {
								//check if a temp image exists
								if ($row->course_image_tmp != "" && file_exists($row->course_image_tmp) && $row->csrf_code == $_POST['csrf_code']) {
									//delete currect course image
									if (file_exists($row->course_image)) {
										unlink($row->course_image);
									}

									$_POST['course_image'] = $row->course_image_tmp;
									$_POST['course_image_tmp'] = "";
								}

								$course->update($id, $_POST);

								$info['data'] = "Course saved successfully";
								$info['data_type'] = "save";
							}
						} else {

							$info['errors'] = $course->errors;
							$info['data'] = "Please fix the errors";
							$info['data_type'] = "save";
						}
					} else {

						$info['errors'] = ['key' => 'value'];
						$info['data'] = "This form is not valid";
						$info['data_type'] = $_POST['data_type'];
					}


					echo json_encode($info);
				} else
					if (!empty($_POST['data_type']) && $_POST['data_type'] == "upload_course_image") {

					$folder = "uploads/courses/";
					if (!file_exists($folder)) {
						mkdir($folder, 0777, true);
					}

					$errors = [];
					if (!empty($_FILES['image']['name'])) {

						$destination = $folder . time() . $_FILES['image']['name'];
						move_uploaded_file($_FILES['image']['tmp_name'], $destination);

						//delete old temp file
						if (file_exists($row->course_image_tmp)) {
							unlink($row->course_image_tmp);
						}

						$course->update($id, ['course_image_tmp' => $destination, 'csrf_code' => $_POST['csrf_code']]);
					}
					//show($_POST);
					//show($_FILES);

				}

				die;
			}
		} else {

			//courses view
			$data['rows'] = $course->where(['user_id' => $user_id]);
		}

		$this->view('admin/courses', $data);
	}

	public function categories($action = null, $id = null)
	{

		if (!Auth::logged_in()) {
			message('please login to view the admin section');
			redirect('login');
		}

		$user_id = Auth::getId();
		$category = new \Model\Category();

		$data = [];
		$data['action'] = $action;
		$data['id'] = $id;

		if ($action == 'add') {


			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				if (user_can('add_categories')) {
					if ($category->validate($_POST)) {

						$_POST['slug'] = str_to_url($_POST['category']);
						$category->insert($_POST);
						message("Your category was successfuly created");
						redirect('admin/categories');
					}
				} else {
					$category->errors['category'] = "You are not allowed to perform this action";
				}

				$data['errors'] = $category->errors;
			}
		} elseif ($action == 'delete') {

			//get category information
			$data['row'] = $row = $category->first(['id' => $id]);

			if ($_SERVER['REQUEST_METHOD'] == "POST" && $row) {


				$category->delete($row->id);
				message("Your category was successfuly edited");
				redirect('admin/categories');

				$data['errors'] = $category->errors;
			}
		} elseif ($action == 'edit') {

			//get category information
			$data['row'] = $row = $category->first(['id' => $id]);

			if ($_SERVER['REQUEST_METHOD'] == "POST" && $row) {
				if ($category->validate($_POST)) {

					$category->update($row->id, $_POST);
					message("Your category was successfuly edited");
					redirect('admin/categories');
				}

				$data['errors'] = $category->errors;
			}
		} else {

			//courses view
			$data['rows'] = $category->findAll();
		}

		$this->view('admin/categories', $data);
	}

	public function roles($action = null, $id = null)
	{

		if (!Auth::logged_in()) {
			message('please login to view the admin section');
			redirect('login');
		}

		$user_id = Auth::getId();
		$role = new \Model\Role();

		$data = [];
		$data['action'] = $action;
		$data['id'] = $id;

		if ($action == 'add') {


			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				if (user_can('add_roles')) {
					if ($role->validate($_POST)) {

						$_POST['slug'] = str_to_url($_POST['role']);
						$role->insert($_POST);
						message("Your role was successfuly created");
						redirect('admin/roles');
					}
				} else {
					$role->errors['role'] = "You are not allowed to perform this action";
				}

				$data['errors'] = $role->errors;
			}
		} elseif ($action == 'delete') {

			//get role information
			$data['row'] = $row = $role->first(['id' => $id]);

			if ($_SERVER['REQUEST_METHOD'] == "POST" && $row) {


				$role->delete($row->id);
				message("Your role was successfuly edited");
				redirect('admin/roles');

				$data['errors'] = $role->errors;
			}
		} elseif ($action == 'edit') {

			//get role information
			$data['row'] = $row = $role->first(['id' => $id]);

			if ($_SERVER['REQUEST_METHOD'] == "POST" && $row) {
				if ($role->validate($_POST)) {

					$role->update($row->id, $_POST);
					message("Your role was successfuly edited");
					redirect('admin/roles');
				}

				$data['errors'] = $role->errors;
			}
		} else {

			//courses view
			$data['rows'] = $role->findAll();

			if ($_SERVER['REQUEST_METHOD'] == "POST") {

				//disable all permissions
				$query = "update permissions_map set disabled = 1 where id > 0";
				$role->query($query);

				foreach ($_POST as $key => $permission) {

					if (preg_match("/[0-9]+\_[0-9]+/", $key)) {
						$role_id = preg_replace("/\_[0-9]+/", "", $key);

						$arr = [];
						$arr['role_id'] = $role_id;
						$arr['permission'] = $permission;

						//check if record exists
						$query = "select id from permissions_map where permission = :permission && role_id = :role_id limit 1";
						$check = $role->query($query, $arr);
						if ($check) {
							//update
							$query = "update permissions_map set disabled = 0 where permission = :permission && role_id = :role_id limit 1";
						} else {
							//insert into permissions table
							$query = "insert into permissions_map (role_id,permission) values (:role_id,:permission)";
						}

						$role->query($query, $arr);
					}
				}

				redirect('admin/roles');
			}
		}

		$this->view('admin/roles', $data);
	}

	public function profile($id = null)
	{

		if (!Auth::logged_in()) {
			message('please login to view the admin section');
			redirect('login');
		}

		$id = $id ?? Auth::getId();

		$user = new \Model\User();
		$data['row'] = $row = $user->first(['id' => $id]);

		if ($_SERVER['REQUEST_METHOD'] == "POST" && $row) {

			$folder = "uploads/images/";
			if (!file_exists($folder)) {
				mkdir($folder, 0777, true);
				file_put_contents($folder . "index.php", "<?php //silence");
				file_put_contents("uploads/index.php", "<?php //silence");
			}

			if ($user->edit_validate($_POST, $id)) {

				$allowed = ['image/jpeg', 'image/png'];

				if (!empty($_FILES['image']['name'])) {

					if ($_FILES['image']['error'] == 0) {

						if (in_array($_FILES['image']['type'], $allowed)) {
							//everything good
							$destination = $folder . time() . $_FILES['image']['name'];
							move_uploaded_file($_FILES['image']['tmp_name'], $destination);

							resize_image($destination);
							$_POST['image'] = $destination;
							if (file_exists($row->image)) {
								unlink($row->image);
							}
						} else {
							$user->errors['image'] = "This file type is not allowed";
						}
					} else {
						$user->errors['image'] = "Could not upload image";
					}
				}

				$user->update($id, $_POST);

				//message("Profile saved successfully");
				//redirect('admin/profile/'.$id);
			}

			if (empty($user->errors)) {
				$arr['message'] = "Profile saved successfully";
			} else {
				$arr['message'] = "Please correct these errors";
				$arr['errors'] = $user->errors;
			}

			echo json_encode($arr);

			die;
		}

		$data['title'] = "Profile";
		$data['errors'] = $user->errors;

		$this->view('admin/profile', $data);
	}

	public function slider_images($id = null)
	{

		if (!Auth::logged_in()) {
			message('please login to view the admin section');
			redirect('login');
		}

		$slider = new Slider();
		$data['rows'] = [];
		$rows = $slider->where(['disabled' => 0]);

		if ($rows) {
			foreach ($rows as $key => $obj) {
				$num = $obj->id;
				$data['rows'][$num] = $obj;
			}
		}

		$id = $_POST['id'] ?? 0;
		$row = $slider->first(['id' => $id]);

		if ($_SERVER['REQUEST_METHOD'] == "POST") {

			$folder = "uploads/images/";
			if (!file_exists($folder)) {
				mkdir($folder, 0777, true);
				file_put_contents($folder . "index.php", "<?php //silence");
				file_put_contents("uploads/index.php", "<?php //silence");
			}

			$allowed = ['image/jpeg', 'image/png'];

			if (!empty($_FILES['image']['name'])) {

				if ($_FILES['image']['error'] == 0) {

					if (in_array($_FILES['image']['type'], $allowed)) {
						//everything good
						$destination = $folder . time() . $_FILES['image']['name'];

						$_POST['image'] = $destination;
					} else {
						$slider->errors['image'] = "This file type is not allowed";
					}
				} else {
					$slider->errors['image'] = "Could not upload image";
				}
			}

			if ($slider->validate($_POST, $id)) {

				if (!empty($destination)) {
					move_uploaded_file($_FILES['image']['tmp_name'], $destination);

					resize_image($destination);
					if ($row && file_exists($row->image)) {
						unlink($row->image);
					}
				}

				if ($row) {
					unset($_POST['id']);
					$slider->update($id, $_POST);
				} else {
					$slider->insert($_POST);
				}

				//message("Image saved successfully");
				//redirect('admin/profile/'.$id);
			}

			if (empty($slider->errors)) {
				$arr['message'] = "Image saved successfully";
			} else {
				$arr['message'] = "Please correct these errors";
				$arr['errors'] = $slider->errors;
			}

			echo json_encode($arr);

			die;
		}

		$data['title'] = "Slider images";
		$data['errors'] = $slider->errors;

		$this->view('admin/slider-images', $data);
	}
}
