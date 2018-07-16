<?php

namespace controllers;

use helpers\Response;
use helpers\UploadImage;
use lib\MVC\Controller\BaseController;

class Home extends BaseController
{
    protected function Index()
    {
        $users = \Users::find('all', array('order' => 'id desc'));
        $arrayUsers = array();
        foreach ($users as $user) {
            $objUser = array("nama" => $user->name, "alamat" => $user->address, "tgl_lahir" => $user->birthdate->format('Y-m-d H:i:s'), "image" => array("600x600" => $user->thumbnail_1, "240x240" => $user->thumbnail_2));
            array_push($arrayUsers, $objUser);
        }
        $viewModel = $arrayUsers;
        $this->RenderView($viewModel, true);
    }
    public function Users()
    {
        try {
            $users = \Users::find('all', array('order' => 'id desc'));
            $arrayUsers = array();
            foreach ($users as $user) {
                $objUser = array("id" => $user->id, "nama" => $user->name, "alamat" => $user->address, "tgl_lahir" => $user->birthdate->format('Y-m-d H:i:s'), "image" => array("600x600" => $user->thumbnail_1, "240x240" => $user->thumbnail_2));
                array_push($arrayUsers, $objUser);
            }
            $result = array("total_result" => count($users), "data" => $arrayUsers,
            );
            Response::sendJSON(200, $result);
        } catch (\Exception $e) {
            $result = array("status" => false, "message" => $e->getMessage());
            Response::sendJSON(500, $result);
        }
    }
    public function Userbyid()
    {
        try {
            if (isset($_GET['id'])) {
                $user = \Users::find(array('conditions' => 'id = ' . $_GET['id']));
                $objUser = array("id" => $user->id ,"nama" => $user->name, "alamat" => $user->address, "tgl_lahir" => $user->birthdate->format('Y-m-d H:i:s'), "email" => $user->email, "image" => array("600x600" => $user->thumbnail_1, "240x240" => $user->thumbnail_2));

                Response::sendJSON(200, $objUser);
            } else {
                $result = array("status" => false, "message" => "Invalid data input");
                Response::sendJSON(400, $result);
            }
        } catch (\Exception $e) {
            $result = array("status" => false, "message" => $e->getMessage());
            Response::sendJSON(500, $result);
        }
    }
    public function Update()
    {
        try {
            if (isset($_GET['id'])) {
                $user = \Users::find(array('conditions' => 'id = ' . $_GET['id']));
                $viewModel = array("id" => $user->id ,"nama" => $user->name, "alamat" => $user->address, "tgl_lahir" => $user->birthdate->format('Y-m-d H:i:s'), "email" => $user->email, "image" => array("600x600" => $user->thumbnail_1, "240x240" => $user->thumbnail_2));

                $this->RenderView($viewModel, true);
            } else {
                $result = array("status" => false, "message" => "Invalid data input");
                Response::sendJSON(400, $result);
            }
        } catch (\Exception $e) {
            $result = array("status" => false, "message" => $e->getMessage());
            Response::sendJSON(500, $result);
        }
    }
    public function User()
    {
        try
        {
            $valid = (isset($_POST["name"]) && isset($_POST["birthdate"]) && isset($_POST["address"]) && isset($_POST["email"]));
            if (!empty($_FILES['image']) && exif_imagetype($_FILES['image']["tmp_name"]) == IMAGETYPE_JPEG && $valid) {
                if ($_FILES['image']['size'] < 20000000) {
                    $upload = UploadImage::upload('image');
                    if ($upload["status"]) {
                        $attributes = array("name" => $_POST["name"], "address" => $_POST["address"], "birthdate" => $_POST["birthdate"], "email" => $_POST["email"], "thumbnail_1" => $upload["image"][0], "thumbnail_2" => $upload["image"][1]);
                        $save = new \Users($attributes);
                        $save->save();
                        $attributes['id'] = $save->id;
                        Response::sendJSON(200, $attributes);
                    } else {
                        Response::sendJSON(400, $upload["message"]);
                    }
                } else {
                    $result = array("status" => false, "message" => "Image to large");
                    Response::sendJSON(400, $result);
                }
            } else {
                $result = array("status" => false, "message" => "Invalid data input");
                Response::sendJSON(400, $result);
            }
        } catch (\Exception $e) {
            $result = array("status" => false, "message" => $e->getMessage());
            Response::sendJSON(500, $result);
        }
    }

    public function Userupdate()
    {
        try
        {
            $user = \Users::find(array('conditions' => 'id = ' . $_POST['id']));
            $user->name =  $_POST['name'];
            $user->address = $_POST['address'];
            $user->birthdate = $_POST['birthdate'];
            $user->email = $_POST['email'];
            if (!empty($_FILES['image']['tmp_name']) && exif_imagetype($_FILES['image']["tmp_name"]) == IMAGETYPE_JPEG && $_FILES['image']['size'] < 20000000) {
                $upload = UploadImage::upload('image');
                if ($upload["status"]) {
                    $user->thumbnail_1 = $upload["image"][0];
                    $user->thumbnail_2 = $upload["image"][1];
                } else {
                    Response::sendJSON(400, $upload["message"]);
                    die();
                }
            }
            $user->save();
            $objUser = array("id" => $user->id ,"nama" => $user->name, "alamat" => $user->address, "tgl_lahir" => $user->birthdate->format('Y-m-d H:i:s'), "image" => array("600x600" => $user->thumbnail_1, "240x240" => $user->thumbnail_2));
            Response::sendJSON(200, $objUser);
        } catch (\Exception $e) {
            $result = array("status" => false, "message" => $e->getMessage());
            Response::sendJSON(500, $result);
        }
    }

    public function Userdelete()
    {
        try
        {
            $user = \Users::table()->delete( array('id' => $_GET['id']));
            Response::sendJSON(200, $_GET['id']);
        } catch (\Exception $e) {
            $result = array("status" => false, "message" => $e->getMessage());
            Response::sendJSON(500, $result);
        }
    }


}
