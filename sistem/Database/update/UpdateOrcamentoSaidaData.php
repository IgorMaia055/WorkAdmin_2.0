<?php

namespace sistem\Database\update;

use sistem\Nucleo\Connection;

class UpdateOrcamentoSaidaData
{
    public function update(string $id_orcamento, bool $condicao = true): void
    {
        $dataNew = 0;
        if($condicao){
            $dataNew = date('Y-m-d');
        }else{
            $dataNew = 0;
        }

        $idInt = intval($id_orcamento);
        $query = "UPDATE orcamentos SET data_saida = '". $dataNew ."' WHERE id = $idInt";
        Connection::getInstancia()->query($query)->fetchAll();
    }
}