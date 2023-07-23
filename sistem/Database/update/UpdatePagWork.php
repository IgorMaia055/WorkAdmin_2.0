<?php

namespace sistem\Database\update;

use sistem\Nucleo\Connection;

class UpdatePagWork
{
    public function update(string $qrcode, string $data_expiration, string $codigo, string $id_orde, string $id): void
    {
        $idInt = intval($id);
        $query = "UPDATE pag_work SET qr_code = '". $qrcode ."', data_expiration = '". $data_expiration ."', codigo_pix = '". $codigo ."', orde_pix = '". $id_orde ."' WHERE id = $idInt";
        Connection::getInstancia()->query($query)->fetchAll();
    }

    public function updatePlano(string $id, string $id_plano): void 
    {
        $idInt = intval($id);
        $idInt2 = intval($id_plano);

        $query = "UPDATE pag_work SET id_plano = $idInt2, codigo_pix = NULL, data_expiration = NULL, qr_code = NULL, orde_pix = NULL WHERE id = $idInt";
        Connection::getInstancia()->query($query)->fetchAll();
    }
}