<?php

namespace sistem\Database\delete;

use sistem\Nucleo\Connection;

class DeleteSaidaOrcamento
{
    public function delete(string $id_orcamento): void
    {
        $idInt = intval($id_orcamento);
        $query = "DELETE FROM saida_orcamento WHERE id_orcamento = '". $idInt ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
    }

}