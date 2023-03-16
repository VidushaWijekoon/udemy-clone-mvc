<?php

/**
 * home class
 */
class Home extends Controller
{

    public function index()
    {
        // $db = new Database();

        // $res = $db->query('SELECT * FROM users', [], 'array');
        // show($res);

        // $users = new User();
        // $users->insert($data);

        $data['title'] = 'This is my homepage';
        $this->view('home', $data);
    }

    public function edit()
    {
        echo "home editing";
    }

    public function delete()
    {
        echo "home deleting ";
    }
}
