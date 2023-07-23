<?php

namespace sistem\Database\update;

use sistem\Nucleo\Connection;

class UpdateEntrada
{
    public function updateValor(int $id, string $valor, int $mes): void
    {
        $query = "UPDATE entradas SET valor = '". $valor ."', mes = $mes WHERE id = $id";
        Connection::getInstancia()->query($query)->fetchAll();
    }
}