<?php

namespace sistem\Database\insert;

use sistem\Nucleo\Connection;

class InsertNotification
{
    public function insert(string $id, string $title, string $description, string $level): void
    {
        $idInt = intval($id);
        $query = "INSERT INTO `notification` (title, `description`, `level`, id_empresa) VALUES ('". $title ."', '". $description ."', '". $level ."', $idInt)";

        $result = Connection::getInstancia()->query($query)->fetchAll();
    }
}