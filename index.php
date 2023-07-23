<?php

include 'vendor/autoload.php';

use sistem\Nucleo\Helpers;
use Pecee\SimpleRouter\SimpleRouter;
use sistem\Nucleo\Connection;

(new Connection)->getInstancia();
session_start();

try {
    SimpleRouter::setDefaultNamespace('sistem\Controlador');

    SimpleRouter::get(ROUTER_BASE. 'cadastro/', 'SiteControl@cadastro');
    SimpleRouter::post(ROUTER_BASE. 'goCadastro/', 'SiteControl@goCadastro');

    SimpleRouter::get(ROUTER_BASE. 'login/{aviso}', 'SiteControl@login');
    SimpleRouter::post(ROUTER_BASE. 'goLogin/', 'SiteControl@goLogin');

    SimpleRouter::get(ROUTER_BASE. 'home/', 'SiteControl@home');
    SimpleRouter::get(ROUTER_BASE. 'exit/', 'SiteControl@exit');
    SimpleRouter::get(ROUTER_BASE. 'conta_pagar/', 'SiteControl@contasPagar');

    SimpleRouter::get(ROUTER_BASE. 'pagar_conta/', 'SiteControl@pagarConta');
    SimpleRouter::get(ROUTER_BASE. 'vencimento/', 'SiteControl@vencimento');

    SimpleRouter::get(ROUTER_BASE. 'orcamentos/', 'SiteControl@orcamentos');
    SimpleRouter::get(ROUTER_BASE. 'documentos/', 'SiteControl@documentos');
    SimpleRouter::get(ROUTER_BASE. 'perfil/', 'SiteControl@perfil');
    SimpleRouter::get(ROUTER_BASE. 'orcamento/criar', 'SiteControl@criarOrcamento');
    
    SimpleRouter::post(ROUTER_BASE. 'insert_imagem_perfil/', 'SiteControl@insert_imagem_perfil');
    SimpleRouter::post(ROUTER_BASE. 'update_tipo_orcamento/', 'SiteControl@update_tipo_orcamento');
    SimpleRouter::post(ROUTER_BASE. 'delete_conta_paga/', 'SiteControl@delete_conta_paga');

    SimpleRouter::get(ROUTER_BASE. 'formNoti/', 'SiteControl@formNoti');

    SimpleRouter::get(ROUTER_BASE. 'newNotification/', 'SiteControl@newNotification');
    
    SimpleRouter::get(ROUTER_BASE. 'busca_notifications/', 'SiteControl@busca_notifications');

    SimpleRouter::post(ROUTER_BASE. 'addOrcamentoSistem/', 'SiteControl@addOrcamentoSistem');

    SimpleRouter::post(ROUTER_BASE. 'updateOrcamentoSistem/', 'SiteControl@updateOrcamentoSistem');
    
    SimpleRouter::get(ROUTER_BASE. 'salvarCor/', 'SiteControl@salvarCor');

    SimpleRouter::get(ROUTER_BASE. 'deleteInfo/{id}', 'SiteControl@deleteInfo');

    SimpleRouter::get(ROUTER_BASE. 'pagamentos/', 'SiteControl@pagamentos');

    SimpleRouter::get(ROUTER_BASE. 'salvarStatesOrcamento/', 'SiteControl@salvarStatesOrcamento');
    
    SimpleRouter::get(ROUTER_BASE. 'buscaFluxoCaixa/', 'SiteControl@buscaFluxoCaixa');

    SimpleRouter::get(ROUTER_BASE. 'deletar_conta_paga/{id}', 'SiteControl@deletar_conta_paga');

    SimpleRouter::post(ROUTER_BASE. 'orcamento/', 'SiteControl@orcamento');
    
    SimpleRouter::post(ROUTER_BASE. 'compartilharWhats/', 'SiteControl@compartilharWhats');
    
    SimpleRouter::post(ROUTER_BASE. 'deletarOrcamento/', 'SiteControl@deletarOrcamento');

    SimpleRouter::get(ROUTER_BASE. 'planos/', 'SiteControl@planos');

    SimpleRouter::post(ROUTER_BASE. 'escolhaPlano/', 'SiteControl@escolhaPlano');

    SimpleRouter::get(ROUTER_BASE. 'pagWork/{aviso}/', 'SiteControl@pagWork');

    //sistema de pix com PagBank
    SimpleRouter::post(ROUTER_BASE. 'sistem_pix_pagbank/', 'SiteControl@sistem_pix_pagbank');

    SimpleRouter::post(ROUTER_BASE. 'consulta_pix_pagwork/', 'SiteControl@consulta_pix_pagwork');

    SimpleRouter::post(ROUTER_BASE. 'pesquisa_orcamento/', 'SiteControl@pesquisa_orcamento');

    SimpleRouter::get(ROUTER_BASE. 'salvarInfoUser/', 'SiteControl@salvarInfoUser');

    SimpleRouter::get(ROUTER_BASE. 'redirectRote/', 'SiteControl@redirectRote');

    SimpleRouter::get(ROUTER_BASE. 'redirectGo/', 'SiteControl@redirectGo');

    SimpleRouter::get(ROUTER_BASE. 'erroWiFi/', 'SiteControl@erroWiFi');

    SimpleRouter::get(ROUTER_BASE. 'recibos/', 'SiteControl@recibos');
    
    SimpleRouter::start();

} catch (Pecee\SimpleRouter\Exceptions\NotFoundHttpException $e) {
    Helpers::redirecionar('home/');
}
