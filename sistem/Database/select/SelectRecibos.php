<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectRecibos
{
    public function select(): array
    {
        $query = "SELECT * FROM recibos WHERE id_empresa = '". $_SESSION['id'] ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}