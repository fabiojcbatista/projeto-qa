<?php

class TeamLeagueDTO {
    public $id_liga;
    public $id_time_cartola;


    public function __construct($data) {
        $this->id_liga = $data['id_liga'] ?? null;
        $this->id_time_cartola = $data['id_time_cartola'] ?? null;
    }

    public function toArray() {
        return [           
            'id_liga'=> $this->id_liga,
            'id_time_cartola'=> $this->id_time_cartola
        ];
    }
}
