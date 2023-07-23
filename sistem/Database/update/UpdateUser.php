<?php

namespace sistem\Database\update;

use sistem\Nucleo\Connection;

class UpdateUser
{
    public function update(array $arr)
    {
        $query = "UPDATE usuarios SET endereco = '". $arr['endereco'] ."', cep = '". $arr['cep'] ."', email = '". $arr['email'] ."', numero_telefone = '". $arr['numero_telefone'] ."', numero_fixo = '". $arr['numero_fixo'] ."', bairro = '". $arr['bairro'] ."', cidade = '". $arr['cidade'] ."', estado = '". $arr['estado'] ."' WHERE id = '". $_SESSION['id'] ."'";

        Connection::getInstancia()->query($query)->fetchAll();
    }
}