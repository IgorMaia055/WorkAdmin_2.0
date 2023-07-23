<?php

namespace sistem\Database\insert;

use sistem\Nucleo\Connection;

class InsertSaida
{
    public function insert(string $id_saida, string $tipo_saida, string $valor): void
    {
        $query = "INSERT INTO saida (id_saida, tipo_saida, id_empresa, valor, mes) VALUES ('". intval($id_saida) ."', '". $tipo_saida ."', '". intval($_SESSION['id']) ."', '". $valor ."', '". date('n') ."')";

        $result = Connection::getInstancia()->query($query)->fetchAll();
    }
}