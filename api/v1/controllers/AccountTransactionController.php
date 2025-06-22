<?php
require_once __DIR__ . '/../models/AccountTransaction.php';
require_once __DIR__ . '/../dto/AccountTransactionDTO.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php';

class AccountTransactionController extends ResponseHelper {
    private $accountTransactionModel;

    public function __construct($db) {
        $this->accountTransactionModel = new AccountTransaction($db);
    }

    public function getAccountTransactions() {
        $accountTransactions = $this->accountTransactionModel->getAccountTransactions();
        if (empty($accountTransactions)) {
            return $this->responseFail('Nenhum registro encontrado', 404);
        }
        $accountTransactionDTOs = array_map(function($accountTransactionData) {
            return (new AccountTransactionDTO($accountTransactionData))->toArray();
        }, $accountTransactions);
        return $this->response($accountTransactionDTOs, 200);
    }
   
    public function getAccountTransactionById($accountTransactionId) {
        $accountTransactions = $this->accountTransactionModel->getAccountTransactionById($accountTransactionId);
        if (empty($accountTransactions)) {
            return $this->responseFail('Nenhum registro encontrado', 404);
        }
        $accountTransactionDTOs = array_map(function($accountTransactionData) {
            return (new AccountTransactionDTO($accountTransactionData));
        }, $accountTransactions);
        return $this->response($accountTransactionDTOs, 200);
    }

    public function deleteAccountTransactionById($accountTransactionId) {
        $result = $this->accountTransactionModel->deleteAccountTransactionById($accountTransactionId);
        if (isset($result['error'])) {
            return $this->responseFail('Erro ao deletar o registro', 500);
        }
        return $this->response(['message' => 'Registro deletado com sucesso'], 204);
    }

    public function createAccountTransaction($data) {
        $accountTransaction = $this->accountTransactionModel->createAccountTransaction($data);
        if (isset($accountTransaction['error'])) {
            return $this->responseFail('Erro ao criar o registro', 500);
        }
        return $this->response(new AccountTransactionDTO($accountTransaction), 201);
    }

    public function updateAccountTransactionById($accountTransactionId, $data) {
        $accountTransaction = $this->accountTransactionModel->updateAccountTransactionById($data, $accountTransactionId);
        if (isset($accountTransaction['error'])) {
            return $this->responseFail('Erro ao atualizar o registro', 500);
        }
        $accountTransactionDTOs = array_map(function($accountTransactionData) {
            return (new AccountTransactionDTO($accountTransactionData))->toArray();
        }, $accountTransaction);
        return $this->response($accountTransactionDTOs, 200);
    }
}
?>