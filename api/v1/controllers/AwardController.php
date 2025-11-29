<?php
require_once __DIR__ . '/../models/Award.php';
require_once __DIR__ . '/../dto/AwardDTO.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php';

class AwardController extends ResponseHelper {
    private $AwardModel;

    public function __construct($db) {
        $this->AwardModel = new Award($db);
    }

    public function getAwards() {
        $Awards = $this->AwardModel->getAwards();
        if (empty($Awards)) {
            return $this->responseFail('Nenhum registro encontrado', 404);
        }
        $AwardDTOs = array_map(function($AwardData) {
            return (new AwardDTO($AwardData))->toArray();
        }, $Awards);
        return $this->response($AwardDTOs, 200);
    }
   
    public function getAwardById($AwardId) {
        $Awards = $this->AwardModel->getAwardById($AwardId);
        if (empty($Awards)) {
            return $this->responseFail('Nenhum registro encontrado', 404);
        }
        $AwardDTOs = array_map(function($AwardData) {
            return (new AwardDTO($AwardData));
        }, $Awards);
        return $this->response($AwardDTOs, 200);
    }

    public function deleteAwardById($AwardId) {
        $result = $this->AwardModel->deleteAwardById($AwardId);
        if (isset($result['error'])) {
            return $this->responseFail('Erro ao deletar o registro', 500);
        }
        return $this->response(['message' => 'Registro deletado com sucesso'], 204);
    }

    public function createAward($data) {
        $Award = $this->AwardModel->createAward($data);
        if (isset($Award['error'])) {
            return $this->responseFail('Erro ao criar o registro', 500);
        }
        return $this->response(new AwardDTO($Award), 201);
    }

    public function updateAwardById($AwardId, $data) {
        $Award = $this->AwardModel->updateAwardById($data, $AwardId);
        if (isset($Award['error'])) {
            return $this->responseFail('Erro ao atualizar o registro', 500);
        }
        $AwardDTOs = array_map(function($AwardData) {
            return (new AwardDTO($AwardData))->toArray();
        }, $Award);
        return $this->response($AwardDTOs, 200);
    }
}
?>
