<?php

class AccountTransactionDTO {
    public $id;
    public $id_conta;
    public $id_usuario;
    public $valor_vencimento;
    public $valor_pagto;
    public $data_venc;
    public $data_pgto;

    public function __construct($accountTransactionData) {
        $this->id = $accountTransactionData['id'] ?? null;
        $this->id_conta = $accountTransactionData['id_conta'] ?? null;
        $this->id_usuario = $accountTransactionData['id_usuario'] ?? null;
        $this->valor_vencimento = $accountTransactionData['valor_vencimento'] ?? null;
        $this->valor_pagto = $accountTransactionData['valor_pagto'] ?? null;
        $this->data_venc = $accountTransactionData['data_venc'] ?? null;
        $this->data_pagto = $accountTransactionData['data_pgto'] ?? null;
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'id_conta' => $this->id_conta,
            'id_usuario' => $this->id_usuario,
            'valor_vencimento' => $this->valor_vencimento,
            'valor_pagto' => $this->valor_pagto,
            'data_venc' => $this->data_venc,
            'data_pgto' => $this->data_pgto
        ];
    }
}
