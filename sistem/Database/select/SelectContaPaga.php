<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectContaPaga
{
    public function select(): array
    {
        $query = "SELECT * FROM conta_pagar WHERE `status` = 0 AND id_empresa = '". $_SESSION['id'] ."' ORDER BY id DESC LIMIT 3";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }

    public function select2(): array 
    {
        $query = "SELECT * FROM conta_pagar WHERE `status` = 0 AND id_empresa = '". $_SESSION['id'] ."' ORDER BY id DESC";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}