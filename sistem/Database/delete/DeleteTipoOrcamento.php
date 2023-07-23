<?php

namespace sistem\Database\delete;

use sistem\Nucleo\Connection;

class DeleteTipoOrcamento
{
    public function delete(string $id): void
    {
        $intval = intval($id);
        $query = "DELETE FROM tipos_orcamentos_devs WHERE id = '". $intval ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
    }

}