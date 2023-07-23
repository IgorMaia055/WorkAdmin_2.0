<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectImagemUser
{
    public function select(): array
    {
        $query = "SELECT imagem_empresa FROM usuarios WHERE id = '". $_SESSION['id'] ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}