<?php
require_once __DIR__ . '/../models/Player.php';
require_once __DIR__ . '/../dto/PlayerDTO.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php';

class PlayerController extends ResponseHelper {
    private $playerModel;

    public function __construct($db) {
        $this->playerModel = new Player($db);
    }

    public function getPlayers() {
        $Players = $this->playerModel->getPlayers();
        if (empty($players)) {
            return $this->responseFail('Nenhum registro encontrado', 404);
        }
        $playerDTOs = array_map(function($playerData) {
            return (new PlayerDTO($playerData))->toArray();
        }, $players);
        return $this->response($playerDTOs, 200);
    }
   
    public function getPlayerById($playerId) {
        $players = $this->playerModel->getPlayerById($playerId);
        if (empty($players)) {
            return $this->responseFail('Nenhum registro encontrado', 404);
        }
        $playerDTOs = array_map(function($playerData) {
            return (new PlayerDTO($playerData));
        }, $players);
        return $this->response($playerDTOs, 200);
    }

    public function deletePlayerById($playerId) {
        $result = $this->playerModel->deletePlayerById($playerId);
        if (isset($result['error'])) {
            return $this->responseFail('Erro ao deletar o registro', 500);
        }
        return $this->response(['message' => 'Registro deletado com sucesso'], 204);
    }

    public function createPlayer($data) {
        $player = $this->playerModel->createPlayer($data);
        if (isset($player['error'])) {
            return $this->responseFail('Erro ao criar o registro', 500);
        }
        return $this->response(new PlayerDTO(pPlayer), 201);
    }

    public function updatePlayerById($playerId, $data) {
        $player = $this->playerModel->updatePlayerById($data, $playerId);
        if (isset($player['error'])) {
            return $this->responseFail('Erro ao atualizar o registro', 500);
        }
        $playerDTOs = array_map(function($playerData) {
            return (new PlayerDTO($playerData))->toArray();
        }, $player);
        return $this->response($playerDTOs, 200);
    }
}
?>