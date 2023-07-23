<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectDiscriminacao
{
    public function select(string $id_orcamento): array
    {
        $idInt = intval($id_orcamento);
        $query = "SELECT * FROM discriminacao WHERE id_orcamento = $idInt";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }

    public function selectDeter($id_discriminacao, string $id_orcamento): array 
    {
        $idIntOrcamento = intval($id_orcamento);

        $idInt = ($id_discriminacao == null ? null : intval($id_discriminacao));
        $where = ($id_discriminacao == null ? "WHERE id_orcamento = $idIntOrcamento" : "WHERE id = $idInt");

        $query = "SELECT id FROM discriminacao $where ORDER BY id DESC";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}