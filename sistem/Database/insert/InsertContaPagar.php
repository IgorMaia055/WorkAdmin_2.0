<?php

namespace sistem\Database\insert;

use sistem\Nucleo\Connection;

class InsertContaPagar
{
    public function insert(string $nome_conta, string $valor_conta, string $vencimento_conta): void
    {
        $query = "INSERT INTO conta_pagar (nome, valor, vencimento, id_empresa) VALUES ('". $nome_conta ."', '". $valor_conta ."', '". $vencimento_conta ."', '". $_SESSION['id'] ."')";
        Connection::getInstancia()->query($query)->fetchAll();
    }
}