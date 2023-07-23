<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectPlano
{
    public function select(string $id): array
    {
        $idInt = intval($id);
        $query = "SELECT * FROM planos WHERE id = $idInt";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }

    public function selectTudo(): array
    {
        $query = "SELECT * FROM planos";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}