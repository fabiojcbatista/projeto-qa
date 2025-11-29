<?php
require_once __DIR__ . '/../models/TeamLeague.php';
require_once __DIR__ . '/../dto/TeamLeagueDTO.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php';

class TeamLeagueController extends ResponseHelper {
    private $TeamLeagueModel;

    public function __construct($db) {
        $this->TeamLeagueModel = new TeamLeague($db);
    }

    public function getTeamLeagues() {
        $TeamLeagues = $this->TeamLeagueModel->getTeamLeagues();
        if (empty($TeamLeagues)) {
            return $this->responseFail('Nenhum registro encontrado', 404);
        }
        $TeamLeagueDTOs = array_map(function($TeamLeagueData) {
            return (new TeamLeagueDTO($TeamLeagueData))->toArray();
        }, $TeamLeagues);
        return $this->response($TeamLeagueDTOs, 200);
    }
   
    public function createTeamLeague($data) {
        $TeamLeague = $this->TeamLeagueModel->createTeamLeague($data);
        if (isset($TeamLeague['error'])) {
            return $this->responseFail('Erro ao criar o registro', 500);
        }
        return $this->response(new TeamLeagueDTO($TeamLeague), 201);
    }

    public function deleteTeamLeague($data) {
        if (empty($data['id_liga']) || empty($data['id_time_cartola'])) {
             return $this->responseFail('Campos id_liga e id_time_cartola são obrigatórios', 400);
        }
        $result = $this->TeamLeagueModel->deleteTeamLeague($data['id_liga'], $data['id_time_cartola']);
        if (isset($result['error'])) {
            return $this->responseFail('Erro ao deletar o registro', 500);
        }
        return $this->response(['message' => 'Registro deletado com sucesso'], 204);
    }
}
?>
