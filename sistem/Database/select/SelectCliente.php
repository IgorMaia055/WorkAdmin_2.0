<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectCliente
{
    public function select(string $cliente, string $telefone): array
    {
        $query = "SELECT * FROM clientes WHERE nome = '". $cliente ."' AND telefone = '". $telefone ."' AND id_empresa = '". $_SESSION['id'] ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }

    public function selectTudo(): array
    {
        $query = "SELECT * FROM clientes WHERE id_empresa = '". $_SESSION['id'] ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }

    public function selectDeter(string $id_cliente) 
    {
        $idInt = intval($id_cliente);

        $query = "SELECT * FROM clientes WHERE id = $idInt";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}