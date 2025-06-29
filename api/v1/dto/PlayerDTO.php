<?php

class PlayerDTO {
    public $id_cartoleiro;
    public $nome;

    public function __construct($playerData) {
        $this->id_cartoleiro = $playerData['id_cartoleiro'] ?? null;
        $this->nome = $playerData['nome'] ?? null;
    }

    public function toArray() {
        return [
            'id_cartoleiro' => $this->id_cartoleiro,
            'nome' => $this->nome
        ];
    }
}
