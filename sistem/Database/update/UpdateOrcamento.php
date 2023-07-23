<?php

namespace sistem\Database\update;

use sistem\Nucleo\Connection;

class UpdateOrcamento
{
    public function update(string $id_orcamento, array $informations): void
    {
        $idInt = intval($id_orcamento);
        $total = 0;
        $mao_obra = 0;
        $total_pecas = 0;
        $data = 0;
        $carro = 0;
        $placa = 0;
        $ano = 0;
        $obs = 0;
        $previsao_entrega = 0;

        if(isset($informations['total'])){
            $total = $informations['total'];
        }
        if(isset($informations['mao_obra'])){
            $mao_obra = $informations['mao_obra'];
        }
        if(isset($informations['total_pecas'])){
            $total_pecas = $informations['total_pecas'];
        }
        if(isset($informations['data'])){
            $data = $informations['data'];
        }
        if(isset($informations['carro'])){
            $carro = $informations['carro'];
        }
        if(isset($informations['placa'])){
            $placa = $informations['placa'];
        }
        if(isset($informations['ano'])){
            $ano = $informations['ano'];
        }
        if(isset($informations['obs'])){
            $obs = $informations['obs'];
        }
        if(isset($informations['previsao_entrega'])){
            $previsao_entrega = $informations['previsao_entrega'];
        }


        $query = "UPDATE orcamentos SET `data` = '". $data ."', carro = '". $carro ."', placa = '". $placa ."', ano = '". $ano ."', obs = '". $obs ."', previsao_entrega = '". $previsao_entrega ."', total_pecas = '". $total_pecas ."', mao_obra = '". $mao_obra ."', total = '". $total ."'  WHERE id = $idInt";
        Connection::getInstancia()->query($query)->fetchAll();
    }
}