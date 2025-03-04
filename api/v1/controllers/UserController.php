<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../dto/UserDTO.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php'; 

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
        $users = $this->userModel->getUserById($userId);
        if (empty($users)) {
            return $this->responseFail('Nenhum registro encontrado', 404);
        }
        $userDTOs = array_map(function($userData) {
            return (new UserDTO($userData));
        }, $users);
        return $this->response($userDTOs, 200);
    }

     public function deleteUserById($userId) {
        $result = $this->userModel->deleteUserById($userId);
if (isset($result['error'])) {
        return $this->responseFail('Erro ao deletar o usuário', 500);
        }
        return $this->response(['message' => 'Usuário deletado com sucesso'], 204);
    }
       
    public function createUser($data) {
        $user = $this->userModel->createUser($data);
        if (isset($user['error'])) {
            return $this->responseFail('Erro ao criar o usuário', 500);
        }
        return $this->response(new UserDTO($user), 201);
    }

    public function updateUserById($userId, $data) {
        $user = $this->userModel->updateUserById($data, $userId);
        if (isset($user['error'])) {
            return $this->responseFail('Erro ao atualizar o usuário', 500);
        }
        $userDTOs = array_map(function($userData) {
            return (new UserDTO($userData))->toArray();
        }, $user);
        return $this->response($userDTOs, 200);
    }
  }
?>