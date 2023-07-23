<?php

namespace sistem\Database\insert;

use sistem\Nucleo\Connection;

class InsertEntrada
{
    public function insert(string $id_orcamento, string $valor, int $mes): void
    {
        $intId = intval($id_orcamento);
        $query = "INSERT INTO entradas (id_empresa, id_orcamento, valor, mes) VALUES ('". $_SESSION['id'] ."', $intId, '". $valor ."', $mes)";

        Connection::getInstancia()->query($query)->fetchAll();
    }
}