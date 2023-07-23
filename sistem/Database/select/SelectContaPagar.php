<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectContaPagar
{
    public function select(): array
    {
        $query = "SELECT * FROM conta_pagar WHERE `status` = 1 AND id_empresa = '". $_SESSION['id'] ."' ORDER BY vencimento ASC LIMIT 3";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}