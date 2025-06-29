<?php
require_once __DIR__ . '/../models/Team.php';
require_once __DIR__ . '/../dto/TeamDTO.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php';

class TeamController extends ResponseHelper {
    private $TeamModel;

    public function __construct($db) {
        $this->TeamModel = new Team($db);
    }

    public function getTeams() {
        $Teams = $this->TeamModel->getTeams();
        if (empty($Teams)) {
            return $this->responseFail('Nenhum registro encontrado', 404);
        }
        $TeamDTOs = array_map(function($TeamData) {
            return (new TeamDTO($TeamData))->toArray();
        }, $Teams);
        return $this->response($TeamDTOs, 200);
    }
   
    public function getTeamById($TeamId) {
        $Teams = $this->TeamModel->getTeamById($TeamId);
        if (empty($Teams)) {
            return $this->responseFail('Nenhum registro encontrado', 404);
        }
        $TeamDTOs = array_map(function($TeamData) {
            return (new TeamDTO($TeamData));
        }, $Teams);
        return $this->response($TeamDTOs, 200);
    }

    public function deleteTeamById($TeamId) {
        $result = $this->TeamModel->deleteTeamById($TeamId);
        if (isset($result['error'])) {
            return $this->responseFail('Erro ao deletar o registro', 500);
        }
        return $this->response(['message' => 'Registro deletado com sucesso'], 204);
    }

    public function createTeam($data) {
        $Team = $this->TeamModel->createTeam($data);
        if (isset($Team['error'])) {
            return $this->responseFail('Erro ao criar o registro', 500);
        }
        return $this->response(new TeamDTO(pTeam), 201);
    }

    public function updateTeamById($TeamId, $data) {
        $Team = $this->TeamModel->updateTeamById($data, $TeamId);
        if (isset($Team['error'])) {
            return $this->responseFail('Erro ao atualizar o registro', 500);
        }
        $TeamDTOs = array_map(function($TeamData) {
            return (new TeamDTO($TeamData))->toArray();
        }, $Team);
        return $this->response($TeamDTOs, 200);
    }
}
?>