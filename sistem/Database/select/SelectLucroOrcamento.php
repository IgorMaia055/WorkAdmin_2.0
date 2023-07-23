<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectLucroOrcamento
{
    public function select(string $id_orcamento): array
    {
        $idInt = intval($id_orcamento);
        $query = "SELECT * FROM lucro_orcamento WHERE id_orcamento = $idInt";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}