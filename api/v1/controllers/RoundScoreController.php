<?php
require_once __DIR__ . '/../models/RoundScore.php';
require_once __DIR__ . '/../dto/RoundScoreDTO.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php';

class RoundScoreController extends ResponseHelper {
    private $RoundScoreModel;

    public function __construct($db) {
        $this->RoundScoreModel = new RoundScore($db);
    }

    public function getRoundScores() {
        $RoundScores = $this->RoundScoreModel->getRoundScores();
        if (empty($RoundScores)) {
            return $this->responseFail('Nenhum registro encontrado', 404);
        }
        $RoundScoreDTOs = array_map(function($RoundScoreData) {
            return (new RoundScoreDTO($RoundScoreData))->toArray();
        }, $RoundScores);
        return $this->response($RoundScoreDTOs, 200);
    }
   
    public function getRoundScoreById($RoundScoreId) {
        $RoundScores = $this->RoundScoreModel->getRoundScoreById($RoundScoreId);
        if (empty($RoundScores)) {
            return $this->responseFail('Nenhum registro encontrado', 404);
        }
        $RoundScoreDTOs = array_map(function($RoundScoreData) {
            return (new RoundScoreDTO($RoundScoreData));
        }, $RoundScores);
        return $this->response($RoundScoreDTOs, 200);
    }

    public function deleteRoundScoreById($RoundScoreId) {
        $result = $this->RoundScoreModel->deleteRoundScoreById($RoundScoreId);
        if (isset($result['error'])) {
            return $this->responseFail('Erro ao deletar o registro', 500);
        }
        return $this->response(['message' => 'Registro deletado com sucesso'], 204);
    }

    public function createRoundScore($data) {
        $RoundScore = $this->RoundScoreModel->createRoundScore($data);
        if (isset($RoundScore['error'])) {
            return $this->responseFail('Erro ao criar o registro', 500);
        }
        return $this->response(new RoundScoreDTO($RoundScore), 201);
    }

    public function updateRoundScoreById($RoundScoreId, $data) {
        $RoundScore = $this->RoundScoreModel->updateRoundScoreById($data, $RoundScoreId);
        if (isset($RoundScore['error'])) {
            return $this->responseFail('Erro ao atualizar o registro', 500);
        }
        $RoundScoreDTOs = array_map(function($RoundScoreData) {
            return (new RoundScoreDTO($RoundScoreData))->toArray();
        }, $RoundScore);
        return $this->response($RoundScoreDTOs, 200);
    }
}
?>
