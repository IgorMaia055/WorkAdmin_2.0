<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectSaida
{
    public function select(int $mes): array
    {
        $query = "SELECT * FROM saida WHERE id_empresa = '". $_SESSION['id'] ."' AND mes = $mes";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}