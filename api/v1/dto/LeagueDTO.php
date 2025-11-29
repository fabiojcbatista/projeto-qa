<?php

class LeagueDTO {
    public $id_liga;
    public $nome;
    public $dt_ini;
    public $dt_fim;


    public function __construct($data) {
        $this->id_liga = $data['id_liga'] ?? null;
        $this->nome = $data['nome'] ?? null;
        $this->dt_ini = $data['dt_ini'] ?? null;
        $this->dt_fim = $data['dt_fim'] ?? null;
    }

    public function toArray() {
        return [           
            'id_liga'=> $this->id_liga,
            'nome'=> $this->nome,
            'dt_ini'=> $this->dt_ini,
            'dt_fim'=> $this->dt_fim
        ];
    }
}
