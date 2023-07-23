<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectTipoOrcamento
{
    public function select(string $id): array
    {
        $query = "SELECT * FROM tipos_orcamentos_devs WHERE id = '". $id ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}