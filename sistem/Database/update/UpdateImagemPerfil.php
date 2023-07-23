<?php

namespace sistem\Database\update;

use sistem\Nucleo\Connection;

class UpdateImagemPerfil
{
    public function update(string $base64): void
    {
        $query = "UPDATE usuarios SET imagem_empresa = '". $base64 ."' WHERE id = '". $_SESSION['id'] ."'";
        Connection::getInstancia()->query($query)->fetchAll();
    }
}