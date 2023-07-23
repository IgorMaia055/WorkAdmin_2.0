<?php

namespace sistem\Database\insert;

use sistem\Nucleo\Connection;

class InsertCor
{
    public function insert(string $nome, string $loja, string $codigo, string $corProxima): void
    {
        $query = "INSERT INTO cor (nome, loja, codigo_cor, cor_proxima, id_empresa) VALUES ('". $nome ."', '". $loja ."', '". $codigo ."', '". $corProxima ."', '". $_SESSION['id'] ."')";

        Connection::getInstancia()->query($query)->fetchAll();
    }
}