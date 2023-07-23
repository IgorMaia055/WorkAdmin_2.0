<?php

namespace sistem\Database\update;

use sistem\Nucleo\Connection;

class UpdateOrcamentoCor
{
    public function update(string $id_cor, string $id_orcamento): void
    {
        $query = "UPDATE orcamentos SET id_cor = '". intval($id_cor) ."' WHERE id = '". intval($id_orcamento) ."'";
        Connection::getInstancia()->query($query)->fetchAll();
    }
}