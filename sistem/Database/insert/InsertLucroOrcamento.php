<?php

namespace sistem\Database\insert;

use sistem\Nucleo\Connection;

class InsertLucroOrcamento
{
    public function insert(array $info, string $id_orcamento): void
    {
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

        $query = "INSERT INTO lucro_orcamento (mao_obra, total_peca_real, total_peca_cliente, custo_material, custo_lavagem, id_orcamento) VALUES ('". $valor_mao_obra ."', '". $valor_peca_real ."', '". $valor_peca_cliente ."', '". $valor_material ."', '". $valor_lavagem ."', '". $id_orcamento ."')";

        Connection::getInstancia()->query($query)->fetchAll();
    }
}