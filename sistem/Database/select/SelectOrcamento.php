<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectOrcamento
{
    public function select(): array
    {
        $query = "SELECT id FROM orcamentos WHERE id_empresa = '". $_SESSION['id'] ."' ORDER BY id DESC";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }

    public function selectTudo(): array
    {
        $query = "SELECT * FROM orcamentos WHERE id_empresa = '". $_SESSION['id'] ."' ORDER BY id DESC";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }

    public function selectDeter(string $id): array
    {
        $query = "SELECT * FROM orcamentos WHERE id = '". intval($id) ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}