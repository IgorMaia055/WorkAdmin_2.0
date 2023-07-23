<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectIdTipoOrcamento
{
    public function select(string $id_orcamento): array
    {
        $idInt = intval($id_orcamento);
        $query = "SELECT id_tipo_orcamento FROM orcamentos WHERE id = $idInt";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}