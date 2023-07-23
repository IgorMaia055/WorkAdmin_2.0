<?php

namespace sistem\Database\update;

use sistem\Nucleo\Connection;

class UpdateTipoOrcamento
{
    public function update(string $id): void
    {
        $idInt = intval($id);
        $query = "UPDATE usuarios SET `tipo_orcamento` = $idInt WHERE id = '". $_SESSION['id'] ."'";
        Connection::getInstancia()->query($query)->fetchAll();
    }
}