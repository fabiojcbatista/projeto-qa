<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../dto/UserDTO.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php'; 
header('Content-Type: application/json');

class UserController extends ResponseHelper {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function getUsers() {
    	$user = $this->userModel->getUsers();
        if (empty($user)) {
            return $this->responseFail('Nenhum registro encontrado', 404);
        }
        $userDTOs = array_map(function($userData) {
            return (new UserDTO($userData))->toArray();
        }, $user);
        return $this->response($userDTOs, 200);
    }
    
    public function getUserById($userId) {
        $user = $this->userModel->getUserById($userId);
        if (empty($user)) {
            return $this->responseFail('Nenhum registro encontrado', 404);
        }
        $userDTOs = array_map(function($userData) {
            return (new UserDTO($userData));
        }, $user);
        return $this->response($userDTOs, 200);
    }

    public function deleteUserById($userId) {
        $user = $this->userModel->deleteUserById($userId);
        return $this->responseFail('Not content', 204);
    }
        
    public function createUser($data) {
        $userModel = new User($this->userModel);
        return $userModel->create($data);
    }
  }

