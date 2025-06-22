<?php
require_once __DIR__ . '/../models/Account.php';
require_once __DIR__ . '/../dto/AccountDTO.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php';

class AccountController extends ResponseHelper {
    private $accountModel;

    public function __construct($db) {
        $this->accountModel = new Account($db);
    }

    public function getAccounts() {
        $accounts = $this->accountModel->getAccounts();
        if (empty($accounts)) {
            return $this->responseFail('Nenhum registro encontrado', 404);
        }
        $accountDTOs = array_map(function($accountData) {
            return (new AccountDTO($accountData))->toArray();
        }, $accounts);
        return $this->response($accountDTOs, 200);
    }
   
    public function getAccountById($accountId) {
        $accounts = $this->accountModel->getAccountById($accountId);
        if (empty($accounts)) {
            return $this->responseFail('Nenhum registro encontrado', 404);
        }
        $accountDTOs = array_map(function($accountData) {
            return (new AccountDTO($accountData));
        }, $accounts);
        return $this->response($accountDTOs, 200);
    }

    public function deleteAccountById($accountId) {
        $result = $this->accountModel->deleteAccountById($accountId);
        if (isset($result['error'])) {
            return $this->responseFail('Erro ao deletar o registro', 500);
        }
        return $this->response(['message' => 'registro deletado com sucesso'], 204);
    }

    public function createAccount($data) {
        $account = $this->accountModel->createAccount($data);
        if (isset($account['error'])) {
            return $this->responseFail('Erro ao criar o registro', 500);
        }
        return $this->response(new AccountDTO($account), 201);
    }

    public function updateAccountById($accountId, $data) {
        $account = $this->accountModel->updateAccountById($data, $accountId);
        if (isset($account['error'])) {
            return $this->responseFail('Erro ao atualizar o registro', 500);
        }
        $accountDTOs = array_map(function($accountData) {
            return (new AccountDTO($accountData))->toArray();
        }, $account);
        return $this->response($accountDTOs, 200);
    }
}
?>