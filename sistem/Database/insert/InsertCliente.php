<?php

namespace sistem\Database\insert;

use sistem\Nucleo\Connection;

class InsertCliente
{
    public function insert(string $nome, string $telefone, string $endereco): void
    {
        $query = "INSERT INTO clientes (id_empresa, nome, telefone, endereco) VALUES ('". $_SESSION['id'] ."', '". $nome ."', '". $telefone ."', '". $endereco ."')";
        Connection::getInstancia()->query($query)->fetchAll();
    }
}