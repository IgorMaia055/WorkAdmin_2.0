<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectIdTipoOrcamentoCliente
{
    public function select(): array
    {
        $query = "SELECT tipo_orcamento FROM usuarios WHERE id = '". $_SESSION['id'] ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }

    public function selectR(): array
    {
        $query = "SELECT tipo_recibo FROM usuarios WHERE id = '". $_SESSION['id'] ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;  
    }
}