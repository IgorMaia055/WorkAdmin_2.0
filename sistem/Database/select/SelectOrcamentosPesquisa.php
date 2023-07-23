<?php

namespace sistem\Database\select;

use sistem\Nucleo\Connection;

class SelectOrcamentosPesquisa
{
    public function select(string $busca): array
    {
        $query = "SELECT * FROM orcamentos WHERE data_entrada LIKE '%{$busca}%' OR carro LIKE '%{$busca}%' OR placa LIKE '%{$busca}%' OR ano LIKE '%{$busca}%' OR data_saida LIKE '%{$busca}%' AND id_empresa = '". $_SESSION['id'] ."' ORDER BY id ASC";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }
}