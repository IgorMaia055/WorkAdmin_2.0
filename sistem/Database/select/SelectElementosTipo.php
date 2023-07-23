<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectElementosTipo
{
    public function select(string $id): array
    {
        $idInt = intval($id);
        $query = "SELECT * FROM elements_devs WHERE id_tipo_orcamento = '". $idInt ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}