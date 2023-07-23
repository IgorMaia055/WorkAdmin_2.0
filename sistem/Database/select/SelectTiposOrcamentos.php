<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectTiposOrcamentos
{
    public function select(): array
    {
        $query = "SELECT * FROM tipos_orcamentos_devs WHERE tipo = 'O' ORDER BY id DESC";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }

    public function selectR(): array
    {
        $query = "SELECT * FROM tipos_orcamentos_devs WHERE tipo = 'R' ORDER BY id DESC";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result; 
    }
}