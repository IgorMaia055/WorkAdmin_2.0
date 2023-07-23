<?php

namespace sistem\Database\update;

use sistem\Nucleo\Connection;

class UpdateLucroOrcamento
{
    public function updateInvestService(string $id_orcamento, bool $pago): void
    {
        $idInt = intval($id_orcamento);
        $query = "UPDATE lucro_orcamento SET invest_service = '". $pago ."' WHERE id_orcamento = $idInt";
        Connection::getInstancia()->query($query)->fetchAll();
    }

    public function update(array $info, string $id_orcamento): void
    {
        $idInt = intval($id_orcamento);
        
        $valor_mao_obra = 0;
        $valor_peca_cliente = 0;
        $valor_peca_real = 0;
        $valor_material = 0;
        $valor_lavagem = 0;

        if(isset($info['lucro_orcamento']['valor_mao_obra'])){
            $valor_mao_obra = $info['lucro_orcamento']['valor_mao_obra'];
        }
        if(isset($info['lucro_orcamento']['valor_peca_cliente'])){
            $valor_peca_cliente = $info['lucro_orcamento']['valor_peca_cliente'];
        }
        if(isset($info['lucro_orcamento']['valor_peca_real'])){
            $valor_peca_real = $info['lucro_orcamento']['valor_peca_real'];
        }
        if(isset($info['lucro_orcamento']['valor_material'])){
            $valor_material = $info['lucro_orcamento']['valor_material'];
        }
        if(isset($info['lucro_orcamento']['valor_lavagem'])){
            $valor_lavagem = $info['lucro_orcamento']['valor_lavagem'];
        }

        $query = "UPDATE lucro_orcamento SET mao_obra = '". $valor_mao_obra ."', total_peca_real = '". $valor_peca_real ."', total_peca_cliente = '". $valor_peca_cliente ."', custo_material = '". $valor_material ."', custo_lavagem = '". $valor_lavagem ."' WHERE id_orcamento = $idInt";

        Connection::getInstancia()->query($query)->fetchAll();
    }
}