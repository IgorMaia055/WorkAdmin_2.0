<?php

namespace sistem\Database\insert;

use sistem\Nucleo\Connection;

class InsertDiscriminacao
{
    public function insert(string $id, string $quantidade, string $discriminacao, string $valor): void
    {
        $id_orcamento = intval($id);

        $query = "INSERT INTO discriminacao (quantidade, discriminacao, valor, id_orcamento) VALUES ('". $quantidade ."', '". $discriminacao ."', '". $valor ."', $id_orcamento)";

        Connection::getInstancia()->query($query)->fetchAll();
    }
}