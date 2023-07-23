<?php

/**
 * Classe para a controlação da aplicação, com ela todas as rotas são conectadas, dados são encontrados e arquivos html são renderizados atravez do twig template. 
 * @author Igor Maia <igormaia055@gmail.com>
 * @copyright Copyright (c) 2023
 */

namespace sistem\Controlador;

// Classes bases
use sistem\Nucleo\Controlador;
use sistem\Nucleo\Helpers;
use sistem\Suporte\Cookie;

//Classes de select na DB
use sistem\Database\select\SelectUser;
use sistem\Database\select\SelectContaPagar;
use sistem\Database\select\SelectContaPagarTudo;
use sistem\Database\select\SelectContaPaga;
use sistem\Database\select\SelectSaida;
use sistem\Database\select\SelectImagemUser;
use sistem\Database\select\SelectTiposOrcamentos;
use sistem\Database\select\SelectTipoOrcamento;
use sistem\Database\select\SelectElementosTipo;
use sistem\Database\select\SelectIdTipoOrcamentoCliente;
use sistem\Database\select\SelectNotifications;
use sistem\Database\select\SelectCliente;
use sistem\Database\select\SelectOrcamento;
use sistem\Database\select\SelectCores;
use sistem\Database\select\SelectPagWork;
use sistem\Database\select\SelectPlano;
use sistem\Database\select\SelectEntrada;
use sistem\Database\select\SelectSaidaOrcamento;
use sistem\Database\select\SelectIdTipoOrcamento;
use sistem\Database\select\SelectDiscriminacao;
use sistem\Database\select\SelectLucroOrcamento;
use sistem\Database\select\SelectFatura;
use sistem\Database\select\SelectOrcamentosPesquisa;
use sistem\Database\select\SelectRecibos;

//Classes de insert na DB
use sistem\Database\insert\InsertContaPagar;
use sistem\Database\insert\InsertSaida;
use sistem\Database\insert\InsertNotification;
use sistem\Database\insert\InsertCliente;
use sistem\Database\insert\InsertOrcamento;
use sistem\Database\insert\InsertDiscriminacao;
use sistem\Database\insert\InsertLucroOrcamento;
use sistem\Database\insert\InsertCor;
use sistem\Database\insert\InsertEntrada;
use sistem\Database\insert\InsertSaidaOrcamento;

//Classes de insert na DB
use sistem\Database\update\UpdateStatusConta;
use sistem\Database\update\UpdateImagemPerfil;
use sistem\Database\update\UpdateTipoOrcamento;
use sistem\Database\update\UpdateOrcamentoCor;
use sistem\Database\update\UpdateCor;
use sistem\Database\update\UpdateOrcamentoStates;
use sistem\Database\update\UpdateEntrada;
use sistem\Database\update\UpdateOrcamentoSaidaData;
use sistem\Database\update\UpdateLucroOrcamento;
use sistem\Database\update\UpdateCliente;
use sistem\Database\update\UpdateOrcamento;
use sistem\Database\update\UpdateDiscriminacao;
use sistem\Database\update\UpdatePagWork;
use sistem\Database\update\UpdateUser;

//Classes de delete na DB
use sistem\Database\delete\DeleteTipoOrcamento;
use sistem\Database\delete\DeleteContaPaga;
use sistem\Database\delete\DeleteInfo;
use sistem\Database\delete\DeleteEntrada;
use sistem\Database\delete\DeleteSaidaOrcamento;
use sistem\Database\delete\DeleteOrcamento;

class SiteControl extends Controlador
{
    public function __construct()
    {
        parent::__construct('views/');
    }

    //Sistema de login
    public function login(string $aviso): void 
    {
        echo $this->template->renderizar('login.html', [
            'aviso' => $aviso
        ]);
    }

    //Sistema de login
    public function goLogin(): void 
    {
        $nome_empresa = filter_input(INPUT_POST,'nome_empresa', FILTER_DEFAULT);
        $senha = filter_input(INPUT_POST,'senha', FILTER_DEFAULT);

        $infoUser = (new SelectUser)->select($nome_empresa, $senha);
        $_SESSION['id'] = $infoUser[0]->id;

        if(!empty($infoUser)){
            $dateNew = date('Y-m-d H:m:s');
            $fatura = (new SelectFatura)->select($infoUser[0]->id);
            if($fatura[0]->data_vencimento . ' 18:00:00' > $dateNew or $fatura[0]->states == 1){
                $_SESSION['nome'] = $infoUser[0]->nome;
                $_SESSION['nome_empresa'] = $infoUser[0]->nome_empresa;
                $_SESSION['tipo_orcamento'] = $infoUser[0]->tipo_orcamento;
                $_SESSION['endereco'] = $infoUser[0]->endereco;
                $_SESSION['cep'] = $infoUser[0]->cep;
                $_SESSION['email'] = $infoUser[0]->email;
                $_SESSION['numero_telefone'] = $infoUser[0]->numero_telefone;
                $_SESSION['numero_fixo'] = $infoUser[0]->numero_fixo;
                $_SESSION['bairro'] = $infoUser[0]->bairro;
                $_SESSION['cidade'] = $infoUser[0]->cidade;
                $_SESSION['estado'] = $infoUser[0]->estado;
                $_SESSION['cnpj'] = $infoUser[0]->cnpj;
                $_SESSION['imagem_empresa'] = $infoUser[0]->imagem_empresa;
    
                Helpers::redirecionar('home/');
            }else{
                Helpers::redirecionar('vencimento/');
            }
        }else{
            Helpers::redirecionar('login/invalid');
        }
    }

    public function vencimento(){
        if(!isset($_SESSION["id"])){
            Helpers::redirecionar('login/enter');
        }else{
        $pag_work = (new SelectPagWork)->selectVencida();
        if(!empty($pag_work)){
            $state = 0;
            if(!empty($pag_work[0]->codigo_pix)){
                $state = 1;
            }
            $plano = (new SelectPlano)->select($pag_work[0]->id_plano);
            $dateNew = date('Y-m-d H:m:s');
    
            echo $this->template->renderizar('vencimento.html', [
                'pag_work' => $pag_work[0],
                'plano' => $plano[0],
                'state' => $state
            ]);
        }else{
            Helpers::redirecionar('login/enter');
        }
        }
    }

    // página principal
    public function home(): void 
    {
        if(!isset($_SESSION["nome"])){
            Helpers::redirecionar('login/enter');
        }else{
            $dateNew = date('Y-m-d H:m:s');
            $fatura = (new SelectFatura)->select($_SESSION['id']);
            if($fatura[0]->data_vencimento . ' 18:00:00' > $dateNew or $fatura[0]->states == 1){

            $contas_pagar = (new SelectContaPagar)->select();
            $contas_pagar_tudo = (new SelectContaPagarTudo)->select();

            $contas_pagas = (new SelectContaPaga)->select();
            $contas_pagas_tudo = (new SelectContaPaga)->select2();

            $notifications = (new SelectNotifications)->select();

            $hoje = date('Y-m-d');

            echo $this->template->renderizar('home.html', [
                'user' => [
                   'nome' => $_SESSION['nome'], 
                   'nome_empresa' => $_SESSION['nome_empresa'],
                   'imagem_empresa' => $_SESSION['imagem_empresa']
                ],
                'contas_pagar' => $contas_pagar,
                'contas_pagar_tudo' => $contas_pagar_tudo,
                'quant_contasPagar' => count($contas_pagar),
                'contas_pagas' => $contas_pagas,
                'contas_pagas_tudo' => $contas_pagas_tudo,
                'quant_contasPagas' => count($contas_pagas),
                'hoje' => $hoje,
                'notifications' => $notifications
            ]);
            }else{
                Helpers::redirecionar('vencimento/');
            }
        }
    }

    public function buscaFluxoCaixa(){

        $mes = intval($_GET['mes']);

        $saidas = (new SelectSaida)->select($mes);
        $saidas_orcamentos = (new SelectSaidaOrcamento)->select($mes);
        $entradas = (new SelectEntrada)->select($mes);
        $orcamentos = (new SelectOrcamento)->selectTudo();

        $valorTotalSaida = 0;
        foreach($saidas as $saida){
            $valor1 = str_replace('.', '', $saida->valor);
            $valor2 = str_replace(',', '.', $valor1);
            $valorFormat = doubleval($valor2);
            $valorTotalSaida += $valorFormat;
        }
        foreach($saidas_orcamentos as $saidas_orcamento){
            $valor = doubleval($saidas_orcamento->valor);
            $valorTotalSaida += $valor;
        }

        $arrDados = [
            'saida' => $valorTotalSaida,
            'entradaInfo' => $entradas,
            'orcamentos' => $orcamentos
        ];

        echo(json_encode($arrDados));
    }

    //Sistema de deslogar o úsuario
    public function exit(): void 
    {
        session_destroy();
        Helpers::redirecionar('login/enter');
    }

    //Sistema de mostrar contas a pagar
    public function contasPagar(): void 
    {
        $nome_conta =  filter_input(INPUT_GET,'nome_conta', FILTER_DEFAULT);
        $valor_conta =  filter_input(INPUT_GET,'valor_conta', FILTER_DEFAULT);
        $vencimento_conta =  filter_input(INPUT_GET,'vencimento_conta', FILTER_DEFAULT);

        (new InsertContaPagar)->insert($nome_conta, $valor_conta, $vencimento_conta);
        Helpers::redirecionar('home/');
    }

    //Sistema de cadastrar conta como paga
    public function pagarConta(): void 
    {
        $id_conta =  filter_input(INPUT_GET,'id_conta', FILTER_DEFAULT);
        $valor =  filter_input(INPUT_GET,'valor', FILTER_DEFAULT);
        
        (new UpdateStatusConta)->update($id_conta);
        (new InsertSaida)->insert($id_conta, 'GF', $valor);
        //GF = Gasto Fixo
        Helpers::redirecionar('home/');
    }

    //Sistema de mostrar todos os orcamentos
    public function orcamentos(): void 
    {
        if(!isset($_SESSION["nome"])){
            Helpers::redirecionar('login/invalid');
        }else{
            $dateNew = date('Y-m-d H:m:s');
            $fatura = (new SelectFatura)->select($_SESSION['id']);
            if($fatura[0]->data_vencimento . ' 18:00:00' > $dateNew or $fatura[0]->states == 1){

        $orcamentos = (new SelectOrcamento)->selectTudo();
        $clientes = (new SelectCliente)->selectTudo();
        $tfOrca = false;

        if(count($orcamentos) != 0){
            $tfOrca = true;
        }

        $cores = (new SelectCores)->select();

        $tiposOrcamentos = (new SelectTiposOrcamentos)->select();
        $newTipoOrcamento = (new SelectIdTipoOrcamentoCliente)->select();

        $notifications = (new SelectNotifications)->select();

        echo $this->template->renderizar('orcamentos.html', [
            'user' => [
                'nome' => $_SESSION['nome'], 
                'nome_empresa' => $_SESSION['nome_empresa'],
                'tipo_orcamento' => $newTipoOrcamento[0]->tipo_orcamento,
                'imagem_empresa' => $_SESSION['imagem_empresa']
            ],
            'tiposOrcamentos' => $tiposOrcamentos,
            'notifications' => $notifications,
            'orcamentos' => $orcamentos,
            'clientes' => $clientes,
            'cores' => $cores,
            'tfOrca' => $tfOrca
        ]);
        }else{
            Helpers::redirecionar('vencimento/');
        }
    }
}

    public function documentos(): void 
    {
        $dateNew = date('Y-m-d H:m:s');
            $fatura = (new SelectFatura)->select($_SESSION['id']);
            if($fatura[0]->data_vencimento . ' 18:00:00' > $dateNew or $fatura[0]->states == 1){

        $notifications = (new SelectNotifications)->select();

        $n =0;
        for($i =0; $i < count($notifications); $i++){
            $n = $i;
        }

        echo $this->template->renderizar('documentos.html', [
            'user' => [
                'nome' => $_SESSION['nome'], 
                'nome_empresa' => $_SESSION['nome_empresa'],
                'endereco' => $_SESSION['endereco'],
                'cep' => $_SESSION['cep'],
                'email' => $_SESSION['email'],
                'numero_telefone' => $_SESSION['numero_telefone'],
                'numero_fixo' => $_SESSION['numero_fixo'],
                'bairro' => $_SESSION['bairro'],
                'cidade' => $_SESSION['cidade'],
                'estado' => $_SESSION['estado'],
                'cnpj' => $_SESSION['cnpj'],
                'imagem_empresa' => $_SESSION['imagem_empresa'],
                'notifications' => $notifications,
                'quantidadeNotifi' => $n
             ]
        ]);
        }else{
            Helpers::redirecionar('vencimento/');
        }
    }

    public function recibos(): void 
    {
        $dateNew = date('Y-m-d H:m:s');
        $fatura = (new SelectFatura)->select($_SESSION['id']);
        if($fatura[0]->data_vencimento . ' 18:00:00' > $dateNew or $fatura[0]->states == 1){

        $notifications = (new SelectNotifications)->select();

        $recibos = (new SelectRecibos)->select();

        
        $tiposRecibos = (new SelectTiposOrcamentos)->selectR();
        $newTipoRecibo = (new SelectIdTipoOrcamentoCliente)->selectR();
        
        $tfRecib = false;
        if(count($recibos) != 0){
            $tfRecib = true;
        }

        $n = count($notifications);

        echo $this->template->renderizar('recibos.html', [
            'user' => [
                'nome' => $_SESSION['nome'], 
                'nome_empresa' => $_SESSION['nome_empresa'],
                'endereco' => $_SESSION['endereco'],
                'cep' => $_SESSION['cep'],
                'email' => $_SESSION['email'],
                'numero_telefone' => $_SESSION['numero_telefone'],
                'numero_fixo' => $_SESSION['numero_fixo'],
                'bairro' => $_SESSION['bairro'],
                'cidade' => $_SESSION['cidade'],
                'estado' => $_SESSION['estado'],
                'cnpj' => $_SESSION['cnpj'],
                'imagem_empresa' => $_SESSION['imagem_empresa'],
                'notifications' => $notifications,
                'quantidadeNotifi' => $n,
                'tfRecib' => $tfRecib,
                'recibos' => $recibos,
                'tiposRecibos' => $tiposRecibos,
                'newTipoRecibo' => $newTipoRecibo
             ]
        ]);
        }else{
            Helpers::redirecionar('vencimento/');
        }
    }

    //Sistema de perfil do úsuario
    public function perfil(): void 
    {
        if(!isset($_SESSION["nome"])){
            Helpers::redirecionar('login/invalid');
        }else{
            $dateNew = date('Y-m-d H:m:s');
            $fatura = (new SelectFatura)->select($_SESSION['id']);
            if($fatura[0]->data_vencimento . ' 18:00:00' > $dateNew or $fatura[0]->states == 1){

            $notifications = (new SelectNotifications)->select();

            $user = (new SelectUser)->selectID();

        echo $this->template->renderizar('perfil.html', [
            'user' => [
                'nome' => $user[0]->nome, 
                'nome_empresa' => $user[0]->nome_empresa,
                'endereco' => $user[0]->endereco,
                'cep' => $user[0]->cep,
                'email' => $user[0]->email,
                'numero_telefone' => $user[0]->numero_telefone,
                'numero_fixo' => $user[0]->numero_fixo,
                'bairro' => $user[0]->bairro,
                'cidade' => $user[0]->cidade,
                'estado' => $user[0]->estado,
                'cnpj' => $user[0]->cnpj,
                'imagem_empresa' => $user[0]->imagem_empresa,
                'notifications' => $notifications
             ]
        ]);
        }else{
            Helpers::redirecionar('vencimento/');
        }
        }
    }

    //Sistema de salvar a imagem de perfil do úsuario
    public function insert_imagem_perfil(): void 
    {
        $imagemPerfil = $_POST['base64'];
        (new UpdateImagemPerfil)->update($imagemPerfil);
        $infoUser = (new SelectImagemUser)->select();
        $_SESSION['imagem_empresa'] = $infoUser[0]->imagem_empresa;
        echo $infoUser[0]->imagem_empresa;
    }

    public function update_tipo_orcamento(): void 
    {
        $id = $_POST['id'];
        (new UpdateTipoOrcamento)->update($id);
        echo 'ok';
    }

    public function criarOrcamento(): void 
    {
        if(!isset($_SESSION["nome"])){
            Helpers::redirecionar('login/invalid');
        }else{
            $dateNew = date('Y-m-d H:m:s');
            $fatura = (new SelectFatura)->select($_SESSION['id']);
            if($fatura[0]->data_vencimento . ' 18:00:00' > $dateNew or $fatura[0]->states == 1){

            $newTipoOrcamento = (new SelectIdTipoOrcamentoCliente)->select();
            
            $tipoOrcamentoRender = (new SelectTipoOrcamento)->select($newTipoOrcamento[0]->tipo_orcamento);
            if($tipoOrcamentoRender){
                $elementosTipoOrcamento = (new SelectElementosTipo)->select($tipoOrcamentoRender[0]->id);

                $notifications = (new SelectNotifications)->select();

                $clientes = (new SelectCliente)->selectTudo();

                echo $this->template->renderizar('criarOrcamento.html', [
                    'user' => [
                        'nome' => $_SESSION['nome'],
                        'nome_empresa' => $_SESSION['nome_empresa'],
                        'tipo_orcamento' => $newTipoOrcamento[0]->tipo_orcamento,
                        'endereco' => $_SESSION['endereco'],
                        'cep' => $_SESSION['cep'],
                        'email' => $_SESSION['email'],
                        'numero_telefone' => $_SESSION['numero_telefone'],
                        'numero_fixo' => $_SESSION['numero_fixo'],
                        'bairro' => $_SESSION['bairro'],
                        'cidade' => $_SESSION['cidade'],
                        'estado' => $_SESSION['estado'],
                        'cnpj' => $_SESSION['cnpj'],
                        'imagem_empresa' => $_SESSION['imagem_empresa']
                    ],
                    'tipoOrcamentoRender' => $tipoOrcamentoRender,
                    'elementosTipoOrcamento' => $elementosTipoOrcamento,
                    'notifications' => $notifications,
                    'clientes' => $clientes
                ]);

            }else{
                Helpers::redirecionar('orcamentos/');
            }
        }else{
            Helpers::redirecionar('vencimento/');
        }

        }
    }

    public function delete_conta_paga():void 
    {
        $id = $_POST['id'];
        (new DeleteContaPaga)->delete($id);
        echo 'ok';
    }

    public function formNoti(){
        echo $this->template->renderizar('formNoti.html', []);
    }

    public function newNotification():void 
    {
        $id =  filter_input(INPUT_GET,'id', FILTER_DEFAULT);
        $title =  filter_input(INPUT_GET,'title', FILTER_DEFAULT);
        $description =  filter_input(INPUT_GET,'description', FILTER_DEFAULT);
        $level =  filter_input(INPUT_GET,'level', FILTER_DEFAULT);

        (new InsertNotification)->insert($id, $title, $description, $level);
    }

    public function busca_notifications(): void
    {
        $notifications = (new SelectNotifications)->select();
        $n =0;
        for($i = 0; $i < count($notifications); $i++){
            $n + 1;
        }
        $notifications['quantidadeNotifi'] = $n;

        echo(json_encode($notifications));
    }

    public function addOrcamentoSistem(): void 
    {
        $user = (new SelectUser)->selectID();

        $informations = $_POST['informations'];

        $clienteNew = (new SelectCliente)->select($informations['cliente'], $informations['telefone_cliente']);
        
        $cliente = '';

        if($clienteNew){
            $cliente = $clienteNew;
        }else{
            // Inserir o cliente primeiro
            (new InsertCliente)->insert($informations['cliente'], $informations['telefone_cliente'], $informations['endereco_cliente']);
            
            //Pegar o id do cliente para colocar no orcamento
            $cliente = (new SelectCliente)->select($informations['cliente'], $informations['telefone_cliente']);
        }
        
        //Inserir o orcamento com as informações e o id do cliente
        (new InsertOrcamento)->insert($cliente[0]->id, $informations, $user[0]->tipo_orcamento);

        //Seleciona o id do orcamento para inserir nas discriminações
        $orcamentoId = (new SelectOrcamento)->select();

        //Inserir valores da lucratividade do orcamento
        (new InsertLucroOrcamento)->insert($informations, $orcamentoId[0]->id);

        if(count($orcamentoId) != 0){
            for($i=1; $i < intval($informations['quantLg']); $i++){

                $quantidadeNew = $informations['quantidade'.$i];
                $discriminacaoNew = $informations['discriminacao'.$i];
                $valorNew = $informations['valor'.$i];

                if($quantidadeNew != '' || $discriminacaoNew != '' || $valorNew != ''){
                    (new InsertDiscriminacao)->insert($orcamentoId[0]->id, $quantidadeNew, $discriminacaoNew, $valorNew);
                }
            }
            echo 'ok';
        }else{
            echo 'Não foi possível selecionar o ID do orçamento';
        }

    }

    public function updateOrcamentoSistem(){
        $informations = $_POST['informations'];

        //Update no cliente
        (new UpdateCliente)->update($informations['cliente'], $informations['telefone_cliente'], $informations['endereco_cliente'], $informations['id_cliente']);

        //Update no orçamento
        (new UpdateOrcamento)->update($informations['id_orcamento'], $informations);

        //Update no lucro orçamento
        (new UpdateLucroOrcamento)->update($informations, $informations['id_orcamento']);

        if(isset($informations['discriminacaoID'])){
            for($i=1; $i < intval($informations['quantLg']); $i++){
                $n = $i - 1;
                $quantidadeNew = $informations['quantidade'.$i];
                $discriminacaoNew = $informations['discriminacao'.$i];
                $valorNew = $informations['valor'.$i];

                if($quantidadeNew != '' || $discriminacaoNew != '' || $valorNew != ''){
                    if(isset($informations['discriminacaoID'][$n])){
                        (new UpdateDiscriminacao)->update($informations['discriminacaoID'][$n], $quantidadeNew, $discriminacaoNew, $valorNew);
                    }else{
                        (new InsertDiscriminacao)->insert($informations['id_orcamento'], $quantidadeNew, $discriminacaoNew, $valorNew); 
                    }
                }
            }
        }else{
            for($i=1; $i < intval($informations['quantLg']); $i++){

                    $quantidadeNew = $informations['quantidade'.$i];
                    $discriminacaoNew = $informations['discriminacao'.$i];
                    $valorNew = $informations['valor'.$i];
    
                    if($quantidadeNew != '' || $discriminacaoNew != '' || $valorNew != ''){
                        (new InsertDiscriminacao)->insert($informations['id_orcamento'], $quantidadeNew, $discriminacaoNew, $valorNew);
                    }
            }
        }

        echo 'ok';
    }

    public function deleteInfo(string $id): void 
    {
        (new DeleteInfo)->delete($id);
    }

    public function salvarCor(): void 
    {
        $id_orcamento =  filter_input(INPUT_GET,'id_orcamento', FILTER_DEFAULT);
        $nome =  filter_input(INPUT_GET,'nome', FILTER_DEFAULT);
        $loja =  filter_input(INPUT_GET,'loja', FILTER_DEFAULT);
        $codigo =  filter_input(INPUT_GET,'codigo', FILTER_DEFAULT);
        $corProxima =  filter_input(INPUT_GET,'corProxima', FILTER_DEFAULT);

        $orcamento = (new SelectOrcamento)->selectDeter($id_orcamento);

        $cores = null;

        (new InsertCor)->insert($nome, $loja, $codigo, $corProxima);
        $cores = (new SelectCores)->selectUm();
        
        (new UpdateOrcamentoCor)->update($cores[0]->id, $id_orcamento);

        Helpers::redirecionar('orcamentos/');
    }

    public function salvarStatesOrcamento(): void 
    {
        $states =  filter_input(INPUT_GET,'statesOrcamento', FILTER_DEFAULT);
        $id_orcamento =  filter_input(INPUT_GET,'id_orcamento', FILTER_DEFAULT);
        $cashEntrada =  filter_input(INPUT_GET,'cashEntrada', FILTER_DEFAULT);
        $investService = filter_input(INPUT_GET,'investService', FILTER_DEFAULT);

        $mes = date('m');
        
        if($states == '0' || $states == '3'){

            if($states == '3'){
                (new UpdateOrcamentoSaidaData)->update($id_orcamento);
                (new InsertSaidaOrcamento)->insert($id_orcamento);
                (new UpdateLucroOrcamento)->updateInvestService($id_orcamento, true);
            }else{
                (new UpdateOrcamentoSaidaData)->update($id_orcamento, false);
                (new DeleteSaidaOrcamento)->delete($id_orcamento);
            }
            
            $entrada = (new SelectEntrada)->selectIdOrcamento(intval($id_orcamento));
            if(count($entrada) != 0){
                (new DeleteEntrada)->delete(intval($entrada[0]->id));
            }

            (new UpdateOrcamentoStates)->update($id_orcamento, $states, 0);
        }else if($states == '1'){

            (new UpdateOrcamentoSaidaData)->update($id_orcamento, false);
    
            $valor1 = str_replace('.', '', $cashEntrada);
            $valor2 = str_replace(',', '.', $valor1);
            $valor = $valor2;
    
    
            (new UpdateOrcamentoStates)->update($id_orcamento, $states, $cashEntrada);
    
            $entrada = (new SelectEntrada)->selectIdOrcamento(intval($id_orcamento));
            if($cashEntrada){
                if(count($entrada) != 0){
                    (new UpdateEntrada)->updateValor(intval($entrada[0]->id), $valor, intval($mes));
                }else{
                    (new InsertEntrada)->insert($id_orcamento, $valor, intval($mes));
                }
            }
        }else if($states == '2' || $states == '4'){

            if($states == '4'){
                (new UpdateOrcamentoSaidaData)->update($id_orcamento);
                (new InsertSaidaOrcamento)->insert($id_orcamento);
                (new UpdateLucroOrcamento)->updateInvestService($id_orcamento, true);
            }else{
                (new UpdateOrcamentoSaidaData)->update($id_orcamento, false);
                (new DeleteSaidaOrcamento)->delete($id_orcamento);
            }

            $orcamentoBusc = (new SelectOrcamento)->selectDeter($id_orcamento);

            $valor1 = str_replace('R', '', $orcamentoBusc[0]->total);
            $valor2 = str_replace('.', '', $valor1);
            $valor3 = str_replace(',', '.', $valor2);
            $valor4 = str_replace('$', '', $valor3);
            $valor5 = str_replace(' ', '', $valor4);
            $valor = $valor5;

            (new UpdateOrcamentoStates)->update($id_orcamento, $states, 0);
    
            $entrada = (new SelectEntrada)->selectIdOrcamento(intval($id_orcamento));
                if(count($entrada) != 0){
                    (new UpdateEntrada)->updateValor(intval($entrada[0]->id), $valor, intval($mes));
                }else{
                    (new InsertEntrada)->insert($id_orcamento, $valor, intval($mes));
                }
        }
        
        if($investService == 'pago' || $states == '3' || $states == '4'){
            (new InsertSaidaOrcamento)->insert($id_orcamento);
            (new UpdateLucroOrcamento)->updateInvestService($id_orcamento, true);
        }else{
            (new DeleteSaidaOrcamento)->delete($id_orcamento);
            (new UpdateLucroOrcamento)->updateInvestService($id_orcamento, false);
        }
        
        Helpers::redirecionar('orcamentos/');
    }

    public function pagamentos(): void
    {
        if(!isset($_SESSION["nome"])){
            Helpers::redirecionar('home/');
        }else{
            $dateNew = date('Y-m-d H:m:s');
            $fatura = (new SelectFatura)->select($_SESSION['id']);
            if($fatura[0]->data_vencimento . ' 18:00:00' > $dateNew or $fatura[0]->states == 1){

            $pag_work = (new SelectPagWork)->select();
            $plano = (new SelectPlano)->select($pag_work[0]->id_plano);

            $hoje = date('Y-m-d');
    
            echo $this->template->renderizar('faturas.html', [
                'user' => [
                    'nome' => $_SESSION['nome'], 
                    'nome_empresa' => $_SESSION['nome_empresa'],
                    'endereco' => $_SESSION['endereco'],
                    'cep' => $_SESSION['cep'],
                    'email' => $_SESSION['email'],
                    'numero_telefone' => $_SESSION['numero_telefone'],
                    'numero_fixo' => $_SESSION['numero_fixo'],
                    'bairro' => $_SESSION['bairro'],
                    'cidade' => $_SESSION['cidade'],
                    'estado' => $_SESSION['estado'],
                    'cnpj' => $_SESSION['cnpj'],
                    'imagem_empresa' => $_SESSION['imagem_empresa']
                ],
                "pag_works" => $pag_work,
                'planos' => $plano,
                'hoje' => $hoje
            ]);
            }else{
                Helpers::redirecionar('vencimento/');
            }

        }
    }

    public function erroWiFi(){
        echo $this->template->renderizar('erroWiFi.html', []);
    }

    public function deletar_conta_paga(string $id): void 
    {
        (new DeleteContaPaga)->delete($id);
        Helpers::redirecionar('home/');
    }

    public function compartilharWhats(): void 
    {

    }

    public function deletarOrcamento(): void
    {
        $id_orcamento = filter_input(INPUT_POST,'id', FILTER_DEFAULT);
        (new DeleteOrcamento)->delete($id_orcamento);
        echo 'ok';
    }

    public function salvarInfoUser(): void 
    {
        $infos = $_GET;
        (new UpdateUser)->update($infos);
        Helpers::redirecionar('perfil/');
    }

    public function orcamento(): void 
    {
        
        if(!isset($_SESSION["nome"])){
            Helpers::redirecionar('login/invalid');
        }else{
            $idOrcamento = filter_input(INPUT_POST,'id_orcamento', FILTER_DEFAULT);

            $idTipoOrcamento = (new SelectIdTipoOrcamento)->select($idOrcamento);
        
            //Buscando por caracteristicas do orçamento
            $tipoOrcamentoRender = (new SelectTipoOrcamento)->select($idTipoOrcamento[0]->id_tipo_orcamento);
            $elementosTipoOrcamento = (new SelectElementosTipo)->select($tipoOrcamentoRender[0]->id);

            //Notificações para o usuario
            $notifications = (new SelectNotifications)->select();

            //Seleciona informações do orçamento
            $orcamento = (new SelectOrcamento)->selectDeter($idOrcamento);

            //Seleciona informações do cliente do orçamento
            $clienteOrcamento = (new SelectCliente)->selectDeter($orcamento[0]->id_cliente);

            //Seleciona discriminações do orçamento
            $discriminacoes = (new SelectDiscriminacao)->select($idOrcamento);

            //Lucro do orçamento
            $lucro_orcamento = (new SelectLucroOrcamento)->select($idOrcamento);

            echo $this->template->renderizar('orcamento.html', [
                'user' => [
                    'nome' => $_SESSION['nome'], 
                    'nome_empresa' => $_SESSION['nome_empresa'],
                    'tipo_orcamento' => $idTipoOrcamento[0]->id_tipo_orcamento,
                    'endereco' => $_SESSION['endereco'],
                    'cep' => $_SESSION['cep'],
                    'email' => $_SESSION['email'],
                    'numero_telefone' => $_SESSION['numero_telefone'],
                    'numero_fixo' => $_SESSION['numero_fixo'],
                    'bairro' => $_SESSION['bairro'],
                    'cidade' => $_SESSION['cidade'],
                    'estado' => $_SESSION['estado'],
                    'cnpj' => $_SESSION['cnpj'],
                    'imagem_empresa' => $_SESSION['imagem_empresa']
                ],
                'tipoOrcamentoRender' => $tipoOrcamentoRender,
                'elementosTipoOrcamento' => $elementosTipoOrcamento,
                'notifications' => $notifications,
                'idOrcamento' => $idOrcamento,

                'orcamento' => $orcamento,
                'clienteOrcamento' => $clienteOrcamento,
                'discriminacoes' => $discriminacoes,
                'lucro_orcamento' => $lucro_orcamento
            ]);
        }
    }

    public function pesquisa_orcamento(): void 
    {
        $busca = $_POST['busca'];
        $orcamentos = (new SelectOrcamentosPesquisa)->select($busca);
        
        echo(json_encode($orcamentos));
    }

    public function busca_cliente(): void 
    {
        $id_cliente = $_POST['id_cliente'];
        echo $id_cliente;
    }

    public function planos(): void 
    {
        $planos = (new SelectPlano)->selectTudo();
        $pagwork = (new SelectPagWork)->select();
        echo $this->template->renderizar('planos.html', [
            'planos' => $planos,
            'id_pagwork' => $pagwork[0]->id
        ]);
    }

    public function escolhaPlano(): void 
    {
        $id_plano = filter_input(INPUT_POST,'id_plano', FILTER_DEFAULT);
        $id_pagwork = filter_input(INPUT_POST,'id_pagwork', FILTER_DEFAULT);

        (new UpdatePagWork)->updatePlano($id_pagwork, $id_plano);
        Helpers::redirecionar('pagWork/pag/?id_pagwork='.$id_pagwork);
    }

    public function pagWork(string $aviso): void 
    {
        if(!empty($_GET['id_pagwork']) AND Helpers::apenNumber($_POST['id_pagwork'])){
            $id_pagwork = filter_input(INPUT_GET,'id_pagwork', FILTER_DEFAULT);

            if(isset($_SESSION['id'])){
            $empresa = (new SelectUser)->selectID();
            $pagwork = (new SelectPagWork)->selectID($id_pagwork, $empresa[0]->id);
                if(!empty($pagwork)){
                        $plano = (new SelectPlano)->select($pagwork[0]->id_plano);
                
                        echo $this->template->renderizar('pagWork.html', [
                            'planos' => $plano,
                            'id_pagwork' => $id_pagwork,
                            'aviso' => $aviso
                        ]);
                }else{
                    Helpers::redirecionar('pagamentos/');
                }
            }else{
                Helpers::redirecionar('login/enter');
            }
        }else{
            Helpers::redirecionar('home/');
        }
    }

    //Método para sistema de pix com o PagBank
    public function sistem_pix_pagbank(): void 
    {   
        if(!empty($_POST['id_plano']) AND !empty($_POST['id_pagwork']) AND Helpers::apenNumber($_POST['id_plano']) AND Helpers::apenNumber($_POST['id_pagwork'])){

            $id_plano = filter_input(INPUT_POST,'id_plano', FILTER_DEFAULT);
            $id_pagwork = preg_replace('/\D/', '', filter_input(INPUT_POST,'id_pagwork', FILTER_DEFAULT));
    
            $plano = (new SelectPlano)->select($id_plano);
            $user = (new SelectUser)->selectID();
            $workadmin = (new SelectPagWork)->selectID($id_pagwork, $_SESSION['id']);
    
            if(!empty($workadmin)){
    
                $qrcode='';
                $data_expiration='';
                $codigo='';
                $orde='';
    
                if(empty($workadmin[0]->codigo_pix)){
                    $cpf = preg_replace('/\D/', '', filter_input(INPUT_POST,'cpf', FILTER_DEFAULT));
    
                    if(Helpers::validarCPF($cpf) || Helpers::validarCNPJ($cpf)){

                    $id_reference = strtolower(str_replace(' ', '', $_SESSION['id'] . $plano[0]->nome . uniqid()));
                    $body = [
                        "reference_id" => $id_reference,
                        "customer" => [
                          "name" => $user[0]->nome,
                          "email" => $user[0]->email,
                          "tax_id" => $cpf
                        ],
                        "items" => [
                            [
                            "name" => "WorkAdmin",
                            "quantity" => 1,
                            "unit_amount" => ($plano[0]->valor * 100)
                            ]
                        ],
                        "qr_codes" => [
                            [
                            "amount" => [
                              "value" => ($plano[0]->valor * 100)
                            ]
                            ]
                        ]
                        ];
            
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_URL, ENDPOINT);
                        curl_setopt($curl, CURLOPT_POST, true);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
                        curl_setopt($curl, CURLOPT_CAINFO, __DIR__."/cacert.pem");
                        curl_setopt($curl, CURLOPT_HTTPHEADER, [
                            'Authorization: Bearer ' . TOKEN,
                            'accept: application/json',
                            'Content-Type: application/json'
                        ]);
            
                        $response = curl_exec($curl);
                        $error = curl_error($curl);
            
                        curl_close($curl);
            
                        if ($error) {
                            echo $this->template->renderizar('erro.html', [
                                    'erro' => $error
                                ]);
                            die();
                        }else{
                            $data = json_decode($response, true);
                            
                            $qrcode = $data['qr_codes'][0]['links'][0]['href'];
                            $data_expiration = $data['qr_codes'][0]['expiration_date'];
                            $codigo = $data['qr_codes'][0]['text'];
                            $orde = $data["id"];
                            (new UpdatePagWork)->update($qrcode, $data_expiration, $codigo, $orde, $id_pagwork);
    
                            self::pag_pix($data['qr_codes'][0]['id']);
                        }
                    }else{
                        Helpers::redirecionar('pagWork/invalid/?id_pagwork='.$id_pagwork);
                    }
                    
                    
                }else{
                    $qrcode = $workadmin[0]->qr_code;
                    $data_expiration = $workadmin[0]->data_expiration;
                    $codigo = $workadmin[0]->codigo_pix;
                    $orde = $workadmin[0]->orde_pix;
                }
    
                    echo $this->template->renderizar('pagamento.html', [
                        'qrcode' => $qrcode,
                        'data_expiration' => $data_expiration,
                        'codigo' => $codigo,
                        'valor' => $plano[0]->valor
                    ]);
                    
                    
            }else{
                $_SESSION['nome'] = $user[0]->nome;
                $_SESSION['nome_empresa'] = $user[0]->nome_empresa;
                $_SESSION['tipo_orcamento'] = $user[0]->tipo_orcamento;
                $_SESSION['endereco'] = $user[0]->endereco;
                $_SESSION['cep'] = $user[0]->cep;
                $_SESSION['email'] = $user[0]->email;
                $_SESSION['numero_telefone'] = $user[0]->numero_telefone;
                $_SESSION['numero_fixo'] = $user[0]->numero_fixo;
                $_SESSION['bairro'] = $user[0]->bairro;
                $_SESSION['cidade'] = $user[0]->cidade;
                $_SESSION['estado'] = $user[0]->estado;
                $_SESSION['cnpj'] = $user[0]->cnpj;
                $_SESSION['imagem_empresa'] = $user[0]->imagem_empresa;
    
                Helpers::redirecionar('home/');
            }
        }
    }

    public function pag_pix($qrCode)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => "https://sandbox.api.pagseguro.com/pix/pay/{$qrCode}",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_SSL_VERIFYPEER => true,
          CURLOPT_CAINFO =>  __DIR__."\cacert.pem",
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_HTTPHEADER => [
            "Authorization: ".TOKEN,
            "accept: application/json"
          ],
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          echo $response;
        }
    }
}
?>