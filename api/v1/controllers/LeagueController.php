<?php
require_once __DIR__ . '/../models/League.php';
require_once __DIR__ . '/../dto/LeagueDTO.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php';

class LeagueController extends ResponseHelper {
    private $LeagueModel;

    public function __construct($db) {
        $this->LeagueModel = new League($db);
    }

    public function getLeagues() {
        $Leagues = $this->LeagueModel->getLeagues();
        if (empty($Leagues)) {
            return $this->responseFail('Nenhum registro encontrado', 404);
        }
        $LeagueDTOs = array_map(function($LeagueData) {
            return (new LeagueDTO($LeagueData))->toArray();
        }, $Leagues);
        return $this->response($LeagueDTOs, 200);
    }
   
    public function getLeagueById($LeagueId) {
        $Leagues = $this->LeagueModel->getLeagueById($LeagueId);
        if (empty($Leagues)) {
            return $this->responseFail('Nenhum registro encontrado', 404);
        }
        $LeagueDTOs = array_map(function($LeagueData) {
            return (new LeagueDTO($LeagueData));
        }, $Leagues);
        return $this->response($LeagueDTOs, 200);
    }

    public function deleteLeagueById($LeagueId) {
        $result = $this->LeagueModel->deleteLeagueById($LeagueId);
        if (isset($result['error'])) {
            return $this->responseFail('Erro ao deletar o registro', 500);
        }
        return $this->response(['message' => 'Registro deletado com sucesso'], 204);
    }

    public function createLeague($data) {
        $League = $this->LeagueModel->createLeague($data);
        if (isset($League['error'])) {
            return $this->responseFail('Erro ao criar o registro', 500);
        }
        return $this->response(new LeagueDTO($League), 201);
    }

    public function updateLeagueById($LeagueId, $data) {
        $League = $this->LeagueModel->updateLeagueById($data, $LeagueId);
        if (isset($League['error'])) {
            return $this->responseFail('Erro ao atualizar o registro', 500);
        }
        $LeagueDTOs = array_map(function($LeagueData) {
            return (new LeagueDTO($LeagueData))->toArray();
        }, $League);
        return $this->response($LeagueDTOs, 200);
    }
}
?>
