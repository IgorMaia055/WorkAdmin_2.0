<?php

namespace sistem\Database\update;

use sistem\Nucleo\Connection;

class UpdateDiscriminacao
{
    public function update(string $id, string $quantidade, string $discriminacao, string $valor): void
    {
        $idInt = intval($id);
        $query = "UPDATE discriminacao SET quantidade = '". $quantidade ."', discriminacao = '". $discriminacao ."', valor = '". $valor ."' WHERE id = $idInt";
        Connection::getInstancia()->query($query)->fetchAll();
    }
}