<?php

namespace sistem\Database\delete;

use sistem\Nucleo\Connection;

class DeleteOrcamento
{
    public function delete(string $id): void
    {
        $intval = intval($id);
        $query = "DELETE FROM orcamentos WHERE id = '". $intval ."'";
        Connection::getInstancia()->query($query)->fetchAll();
    }

}