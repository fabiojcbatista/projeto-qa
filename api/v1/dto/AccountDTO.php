<?php

class AccountDTO {
    public $id;
    public $descricao;
    public $tipo;

    public function __construct($accountData) {
        $this->id = $accountData['id'] ?? null;
        $this->descricao = $accountData['descricao'] ?? null;
        $this->tipo = $accountData['tipo'] ?? null;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'descricao' => $this->descricao,
            'tipo' => $this->tipo
        ];
    }
}
