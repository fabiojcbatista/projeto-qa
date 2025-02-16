<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../dto/UserDTO.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php'; 
header('Content-Type: application/json');

class AuthController extends ResponseHelper {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function login($data) {      
        if (!isset($data['email'], $data['senha'])) return $this->responseFail('Email and password are required', 400);
        $user = $this->userModel->findUserByEmail(trim($data['email']));
        if ($data['senha'] !== $user['SENHAUSUARIO']) return $this->responseFail('Invalid email or password',401);
        return $this->response((new UserDTO($user))->toArray(), 200);
    }
 }
