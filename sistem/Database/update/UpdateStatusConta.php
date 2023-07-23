<?php

namespace sistem\Database\update;

use sistem\Nucleo\Connection;

class UpdateStatusConta
{
    public function update(string $id_conta): void
    {
        $query = "UPDATE conta_pagar SET `status` = '". 0 ."', data_pagamento = '". date('Y-m-d') ."' WHERE id = '". intval($id_conta) ."'";
        Connection::getInstancia()->query($query)->fetchAll();
    }
}