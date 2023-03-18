<?php

namespace Model;

/**
 * main model class
 */

use \Database;

class Model extends Database
{

	public $order = 'desc';
	public $limit = 10;
	public $offset = 0;

	protected $table = "";

	public function insert($data)
	{

		//remove unwanted columns
		if (!empty($this->allowedColumns)) {
			foreach ($data as $key => $value) {
				if (!in_array($key, $this->allowedColumns)) {
					unset($data[$key]);
				}
			}
		}

		$keys = array_keys($data);

		$query = "insert into " . $this->table;
		$query .= " (" . implode(",", $keys) . ") values (:" . implode(",:", $keys) . ")";

		$this->query($query, $data);
	}

	public function update($id, $data)
	{

		//remove unwanted columns
		if (!empty($this->allowedColumns)) {
			foreach ($data as $key => $value) {
				if (!in_array($key, $this->allowedColumns)) {
					unset($data[$key]);
				}
			}
		}

		$keys = array_keys($data);
		$query = "update " . $this->table . " set ";

		foreach ($keys as $key) {
			$query .= $key . "=:" . $key . ",";
		}

		$query = trim($query, ",");
		$query .= " where id = :id ";

		$data['id'] = $id;
		$this->query($query, $data);
	}

	public function findAll()
	{

		$query = "select * from " . $this->table . " order by id $this->order limit $this->limit offset $this->offset";

		$res = $this->query($query);

		if (is_array($res)) {
			//run afterSelect functions
			if (property_exists($this, 'afterSelect')) {
				foreach ($this->afterSelect as $func) {

					$res = $this->$func($res);
				}
			}

			return $res;
		}

		return false;
	}

	public function delete(int $id): bool
	{

		$query = "delete from " . $this->table . " where id = :id limit 1";
		$this->query($query, ['id' => $id]);

		return true;
	}

	public function where($data)
	{

		$keys = array_keys($data);

		$query = "select * from " . $this->table . " where ";

		foreach ($keys as $key) {
			$query .= $key . "=:" . $key . " && ";
		}

		$query = trim($query, "&& ");
		$query .= " order by id $this->order limit $this->limit offset $this->offset";
		$res = $this->query($query, $data);

		if (is_array($res)) {

			//run afterSelect functions
			if (property_exists($this, 'afterSelect')) {
				foreach ($this->afterSelect as $func) {

					$res = $this->$func($res);
				}
			}

			return $res;
		}

		return false;
	}

	public function first($data)
	{

		$keys = array_keys($data);

		$query = "select * from " . $this->table . " where ";

		foreach ($keys as $key) {
			$query .= $key . "=:" . $key . " && ";
		}

		$query = trim($query, "&& ");
		$query .= " order by id $this->order limit 1";

		$res = $this->query($query, $data);

		if (is_array($res)) {

			//run afterSelect functions
			if (property_exists($this, 'afterSelect')) {
				foreach ($this->afterSelect as $func) {

					$res = $this->$func($res);
				}
			}

			return $res[0];
		}

		return false;
	}
}
