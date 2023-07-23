<?php

namespace sistem\Database\delete;

use sistem\Nucleo\Connection;

class DeleteContaPaga
{
    public function delete(string $id): void
    {
        $intval = intval($id);
        $query = "DELETE FROM conta_pagar WHERE id = '". $intval ."'";
        Connection::getInstancia()->query($query)->fetchAll();
    }
}