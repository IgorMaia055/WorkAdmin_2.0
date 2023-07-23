<?php

namespace sistem\Database\update;

use sistem\Nucleo\Connection;

class UpdateCliente
{
    public function update(string $nome, string $telefone, string $endereco, string $id_cliente): void
    {
        $idInt = intval($id_cliente);
        $query = "UPDATE clientes SET nome = '". $nome ."', telefone = '". $telefone ."', endereco = '". $endereco ."' WHERE id = $idInt";
        Connection::getInstancia()->query($query)->fetchAll();
    }
}