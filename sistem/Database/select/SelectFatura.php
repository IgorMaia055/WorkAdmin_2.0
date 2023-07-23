<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectFatura
{
    public function select(string $id_empresa): array
    {
        $idInt = intval($id_empresa);
        $query = "SELECT * FROM pag_work WHERE id = $idInt ORDER BY id DESC LIMIT 1";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}