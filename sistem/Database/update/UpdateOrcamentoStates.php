<?php

namespace sistem\Database\update;

use sistem\Nucleo\Connection;

class UpdateOrcamentoStates
{
    public function update(string $id_orcamento, string $states, string $entrada_cash): void
    {
        $statesInt = intval($states);
        $idInt = intval($id_orcamento);

        $query = "UPDATE orcamentos SET `status` = $statesInt, entrada_cash = '". $entrada_cash ."' WHERE id = $idInt";
        Connection::getInstancia()->query($query)->fetchAll();
    }
}