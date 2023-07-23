<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectNotifications
{
    public function select(): array
    {
        $query = "SELECT * FROM `notification` WHERE id_empresa = '". $_SESSION['id'] ."' ORDER BY `id` ASC";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}