<?php

namespace sistem\Database\update;

use sistem\Nucleo\Connection;

class UpdateCor
{
    public function update(string $id, string $nome, string $loja, string $codigo, string $cor_proxima): void
    {
        $query = "UPDATE cor SET nome = '". $nome ."', loja = '". $loja ."', codigo_cor = '". $codigo ."', cor_proxima = '". $cor_proxima ."' WHERE id = '". intval($id) ."'";
        Connection::getInstancia()->query($query)->fetchAll();
    }
}