<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectEntrada
{
    public function selectIdOrcamento(int $id_orcamento): array
    {
        $query = "SELECT id FROM entradas WHERE id_orcamento = $id_orcamento";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }

    public function select(int $mes): array
    {
        $query = "SELECT * FROM entradas WHERE id_empresa = '". $_SESSION['id'] ."' AND mes = $mes ORDER BY id DESC";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}