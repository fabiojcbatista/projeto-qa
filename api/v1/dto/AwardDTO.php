<?php

class AwardDTO {
    public $id_premiacao;
    public $id_liga;
    public $pos;
    public $valor;


    public function __construct($data) {
        $this->id_premiacao = $data['id_premiacao'] ?? null;
        $this->id_liga = $data['id_liga'] ?? null;
        $this->pos = $data['pos'] ?? null;
        $this->valor = $data['valor'] ?? null;
    }

    public function toArray() {
        return [           
            'id_premiacao'=> $this->id_premiacao,
            'id_liga'=> $this->id_liga,
            'pos'=> $this->pos,
            'valor'=> $this->valor
        ];
    }
}
