<?php

class RoundScoreDTO {
    public $id_pontuacao_rodada;
    public $id_time_cartola;
    public $pontos;
    public $ano;


    public function __construct($data) {
        $this->id_pontuacao_rodada = $data['id_pontuacao_rodada'] ?? null;
        $this->id_time_cartola = $data['id_time_cartola'] ?? null;
        $this->pontos = $data['pontos'] ?? null;
        $this->ano = $data['ano'] ?? null;
    }

    public function toArray() {
        return [           
            'id_pontuacao_rodada'=> $this->id_pontuacao_rodada,
            'id_time_cartola'=> $this->id_time_cartola,
            'pontos'=> $this->pontos,
            'ano'=> $this->ano
        ];
    }
}
