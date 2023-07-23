<?php

namespace sistem\Database\insert;

use sistem\Nucleo\Connection;

class InsertSaidaOrcamento
{
    public function insert(string $id_orcamento)
    {
        $mes = date('m'); 

        $idInt = intval($id_orcamento);
        $query = "SELECT * FROM lucro_orcamento WHERE id_orcamento = $idInt";
        $result = Connection::getInstancia()->query($query)->fetchAll();

        $peca_real1 = str_replace('.', '', $result[0]->total_peca_real);
        $peca_real2 = str_replace(',', '.', $peca_real1);
        $peca_real = doubleval($peca_real2);

        $custo_material1 = str_replace('.', '', $result[0]->custo_material);
        $custo_material2 = str_replace(',', '.', $custo_material1);
        $custo_material = doubleval($custo_material2);

        $custo_lavagem1 = str_replace('.', '', $result[0]->custo_lavagem);
        $custo_lavagem2 = str_replace(',', '.', $custo_lavagem1);
        $custo_lavagem = doubleval($custo_lavagem2);

        $totalSaida = $peca_real + $custo_lavagem + $custo_material;

        $query4 = "SELECT * FROM saida_orcamento WHERE id_orcamento = $idInt";
        $result4 = Connection::getInstancia()->query($query4)->fetchAll();
        if(count($result4) != 0){
            $idSaida = intval($result[0]->id);
            $query3 = "UPDATE saida_orcamento SET valor = '". $totalSaida ."', mes = $mes WHERE id = $idSaida";
            Connection::getInstancia()->query($query3)->fetchAll();
        }else{
            $query2 = "INSERT INTO saida_orcamento (id_empresa, id_orcamento, valor, mes) VALUES ('". $_SESSION['id'] ."', $idInt, '". $totalSaida ."', $mes)";
            Connection::getInstancia()->query($query2)->fetchAll();
        }

    }
}