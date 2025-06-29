<?php

class TeamDTO {
    public $id_time_cartola;
    public $id_cartoleiro;
    public $ind_representante;
    public $nome;
    public $pontos;
    public $ano;


    public function __construct($teamData) {
        $this->id_time_cartola = $teamData['id_time_cartola'] ?? null;
        $this->id_cartoleiro = $teamData['id_cartoleiro'] ?? null;
        $this->ind_representante = $teamData['ind_representante'] ?? null;
        $this->nome = $teamData['nome'] ?? null;
        $this->pontos = $teamData['pontos'] ?? null;
        $this->ano = $teamData['ano'] ?? null;
    }

    public function toArray() {
        return [           
            'id_cartoleiro'=>  $this->id_cartoleiro,
            'id_time_cartola'=> $this->id_time_cartola,
            'ind_representante'=> $this->ind_representante,
            'nome'=> $this->nome,
            'pontos'=> $this->pontos,
            'ano'=> $this->ano
        ];
    }
}
