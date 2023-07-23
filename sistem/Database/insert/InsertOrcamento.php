<?php

namespace sistem\Database\insert;

use sistem\Nucleo\Connection;

class InsertOrcamento
{
    public function insert(string $id_cliente, array $informations, $tipo_orcamento)
    {
        $id_cliente_int = intval($id_cliente);
        $id_tipo_orcamento_int = intval($tipo_orcamento);
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

        $query = "INSERT INTO orcamentos (id_empresa, id_cliente, `data`, carro, placa, ano, obs, previsao_entrega, total_pecas, mao_obra, total, id_tipo_orcamento) VALUES ('". $_SESSION['id'] ."', $id_cliente_int, '". $data ."', '". $carro ."', '". $placa ."', '". $ano ."', '". $obs ."', '". $previsao_entrega ."', '". $total_pecas ."', '". $mao_obra ."', '". $total ."', '". $id_tipo_orcamento_int ."')";

        Connection::getInstancia()->query($query)->fetchAll();
    }
}