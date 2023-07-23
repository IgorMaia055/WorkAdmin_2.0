<?php

namespace sistem\Database\insert;

use sistem\Nucleo\Connection;
use sistem\Nucleo\Helpers;

class InsertUser
{
    public function insert(array $dados): void
    {
        $query = "INSERT INTO usuarios () VALUES ()";

        $result = Connection::getInstancia()->query($query)->fetchAll();
    }
}