<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectUser
{
    public function select(string $nome_empresa, string $senha): array
    {
        $query = "SELECT * FROM usuarios WHERE nome_empresa = '". $nome_empresa ."' AND senha = '". $senha ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }

    public function selectID(): array
    {
        $query = "SELECT * FROM usuarios WHERE id = '". $_SESSION['id'] ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}