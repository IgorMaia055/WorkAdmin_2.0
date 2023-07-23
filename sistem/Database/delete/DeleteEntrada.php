<?php

namespace sistem\Database\delete;

use sistem\Nucleo\Connection;

class DeleteEntrada
{
    public function delete(int $id): void
    {
        $query = "DELETE FROM entradas WHERE id = $id";
        Connection::getInstancia()->query($query)->fetchAll();
    }

}