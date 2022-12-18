<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Users;
class UsersController extends BaseController
{
    public function index()
    {
        return view('index');
    }

    public function getUsers(){

        $request = service('request');
        $postData = $request->getPost();

        $response = array();

        // Read new token and assign in $response['token']
        $response['token'] = csrf_hash();
        $data = array();

        if(isset($postData['search'])){

            $search = $postData['search'];

            // Fetch record
            $users = new Users();
            $userlist = $users->select('id,name')
                ->like('name',$search)
                ->orderBy('name')
                ->findAll(5);
            foreach($userlist as $user){
                $data[] = array(
                    "value" => $user['id'],
                    "label" => $user['name'],
                );
            }
        }

        $response['data'] = $data;

        return $this->response->setJSON($response);

    }
}
