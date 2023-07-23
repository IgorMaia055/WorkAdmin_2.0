<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectCores
{
    public function select(): array
    {
        $query = "SELECT * FROM cor WHERE id_empresa = '". $_SESSION['id'] ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }

    public function selectUm(): array
    {
        $query = "SELECT * FROM cor WHERE id_empresa = '". $_SESSION['id'] ."' ORDER BY id DESC LIMIT 1";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }

    public function selectDeter(string $id): array
    {
        $query = "SELECT * FROM cor WHERE id = '". intval($id) ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}