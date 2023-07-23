<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectPagWork
{
    public function select(): array
    {
        $query = "SELECT * FROM pag_work WHERE id_empresa = '". $_SESSION['id'] ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }

    public function selectVencida(): array
    {
        $query = "SELECT * FROM pag_work WHERE id_empresa = '". $_SESSION['id'] ."' AND states = 0 ORDER BY id DESC LIMIT 1";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }

    public function selectID(string $id, string $id_empresa): array
    {
        $idInt = intval($id);
        $id_empresaInt = intval($id_empresa);

        $query = "SELECT * FROM pag_work WHERE id_empresa = $id_empresaInt AND id = $idInt AND states = 0";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}