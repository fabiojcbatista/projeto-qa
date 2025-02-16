<?php

class UserDTO {
    public $id;
    public $nome;
    public $email;
    public $nivel;

    public function __construct($userData) {
        $this->id = $userData['IDUSUARIO'] ?? null;
        $this->nome = $userData['NOMEUSUARIO'] ?? null;
        $this->email = $userData['LOGINUSUARIO'] ?? null;
        $this->nivel = $userData['NIVELUSUARIO'] ?? null;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'email' => $this->email,
            'nivel' => $this->nivel
        ];
    }
}
