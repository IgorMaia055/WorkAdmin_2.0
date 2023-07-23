<?php

namespace sistem\Nucleo;

use PHPMailer\PHPMailer\Exception;
use sistem\Nucleo\Connection;

class Helpers
{

    public static function redirecionar(string $url = null): void 
    {
        header('HTTP/1.1 302 Found');

        $local = ($url ? self::url($url) : self::url());

        header("Location: {$local}");
        exit();
    }

    /**
     * Método para validar um cpf
     * @param string $cpf cpf a ser validado
     * @return bool Verdadeiro ou Falso
     */
     
    public static function formataMoeda (float $valor = null, string $moeda = 'R$'): string
    {
        $valueFormat = $moeda .' '. number_format($valor, 2, ',', '.');
        return $valueFormat;
    }
    
    //Boas vindas 
    public static function msgBoaVinda ():string 
    {
        $hora = date('H');
        if ($hora >= 5 && $hora <= 12) {
            return 'Bom dia!';
        } elseif ($hora >= 13 && $hora <= 20) {
            return 'Boa tarde!';
        } else {
            return 'Boa noite!';
        }
    }
    
    public static function formataValor (string $value = null): float
    {
        return number_format(($value ? $value : 0), 0, '.', '.');
    }
    public static function formataNumber (string $value = null): int
    {
        $replaceVar = str_replace(".", "", $value);
        $replaceVar2 = str_replace(",", ".", $replaceVar);

        return intval($replaceVar2);
    }
    
    /**
     * Método para resumir uma string
     * @param string $texto texto para resumir
     * @param int $limit limite para fatorar o texto
     * @param string $continue opcional continuação adicionada no texto para inicar continuamento
     * @return string texto resumido
     */
    
     public static function resumirTxt(string $texto, int $limit, string $continue = '...'): string
     {
         $textoLimp = self::filterStr(trim(strip_tags($texto)));
         if(mb_strlen($texto) <= $limit)
         {
             return $textoLimp;
         }
     
         $textoSub = mb_substr($textoLimp, 0, $limit);
         return $textoSub . $continue;
     }
    
    
    /**
     * Método contador de tempo
     * @param string $data A data da publicação vindo do banco de dados
     * @return string Diferença de tempo
     */
    
    public static function contarTempo (string $data): string
    {
        $dateNew = strtotime(date('Y-m-d H:i:s'));
        $time = strtotime($data);
        $diferenca = $dateNew - $time;
    
        $segundos = round($diferenca);
        $minutos = round($diferenca / 60);
        $horas = round($diferenca / 3600);
        $dias = round($diferenca / 86400);
        $semanas = round($diferenca / 604800);
        $meses = round($diferenca / 2419200);
        $anos = round($diferenca / 29030400);
    
    
        $dateFormatNew = match (true)
        {
            $segundos <= 60 => 'Agora',
            $minutos <= 60 => $minutos.'m',
            $horas <= 23 => $horas.'h',
            $dias <= 7 => $dias.'d',
            $semanas <= 4 => $semanas.'s',
            $meses <= 12 => $meses.'me',
            default => $anos.'a'
        };
    
        return $dateFormatNew;
    
    }

    public static function diferencaTempo (string $entrega, string $dataR): string
    {
        $entregaAmr = str_replace('/', '-', $entrega);
        $dataRAmr = str_replace('/', '-', $dataR);
        $entregaLimp = strtotime($entregaAmr);
        $dataRlimp = strtotime($dataRAmr);

        $diferenca = $entregaLimp - $dataRlimp;
    
        $segundos = round($diferenca);
        $minutos = round($diferenca / 60);
        $horas = round($diferenca / 3600);
        $dias = round($diferenca / 86400);
        $semanas = round($diferenca / 604800);
        $meses = round($diferenca / 2419200);
        $anos = round($diferenca / 29030400);
    
    
        $dateFormatNew = match (true)
        {
            $segundos <= 60=> 'Menos de um minuto',
            $minutos <= 60 => $minutos == 1 ? '1 minuto' : $minutos.' minutos',
            $horas <= 24 => $horas == 1 ? 'Há 1 hora' : $horas.' horas',
            $dias <= 7 => $dias == 1 ? 'Há 1 dia' : $dias.' dias',
            $semanas <= 4 => $semanas == 1 ? 'Há 1 semana' : $semanas.' semanas',
            $meses <= 12 => $meses == 1 ? 'Há 1 mês' : $meses.' mêses',
            default => $anos == 1 ? 'Há 1 ano' : $anos.' anos'
        };
    
        return $dateFormatNew;
    
    }

    public static function diferencaTempoDia (string $entrega, string $dataR)
    {
        $entregaAmr = str_replace('/', '-', $entrega);
        $dataRAmr = str_replace('/', '-', $dataR);
        $entregaLimp = strtotime($entregaAmr);
        $dataRlimp = strtotime($dataRAmr);

        $diferenca = $entregaLimp - $dataRlimp;
    
        $dias = round($diferenca / 86400);
        return $dias;
    }
    
    public static function diferencaTempoService(string $entrega, string $data)
    {
        $entregaAmr = str_replace('.', '-', $entrega);
        $entrega2 = str_replace('000', '', $entregaAmr);
        $dataRAmr = str_replace('.', '-', $data);
        $data2 = str_replace('000', '', $dataRAmr);
        $entregaLimp = strtotime($entrega2);
        $dataRlimp = strtotime($data2);

        $diferenca = $dataRlimp - $entregaLimp;

        $segundos = round($diferenca);
        $minutos = round($diferenca / 60);
        $horas = round($diferenca / 3600);
        $dias = round($diferenca / 86400);
        $semanas = round($diferenca / 604800);
        $meses = round($diferenca / 2419200);
        $anos = round($diferenca / 29030400);
    
        $dateFormatNew = match (true)
        {
            $segundos <= 60 => 'Menos de um minuto',
            $minutos <= 60 => $minutos == 1 ? '1 minuto' : $minutos.' minutos',
            $horas <= 24 => $horas == 1 ? '1 hora' : $horas.' horas',
            $dias <= 7 => $dias == 1 ? '1 dia' : $dias.' dias',
            $semanas <= 4 => $semanas == 1 ? '1 semana' : $semanas.' semanas',
            $meses <= 12 => $meses == 1 ? '1 mês' : $meses.' mêses',
            default => $anos == 1 ? '1 ano' : $anos.' anos'
        };

        return $dateFormatNew;
    }

    function validarEmail(string $email) {
        // Verifica se o formato do e-mail é válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        // Verifica se o domínio do e-mail possui registros MX (Mail Exchanger)
        $domain = explode("@", $email)[1];
        if (!checkdnsrr($domain, "MX")) {
            return false;
        }
        return true;
    }

    public static function validaUrl (string $url): bool
    {
        return filter_var ($url, FILTER_VALIDATE_URL);
    }
    
    /**
     * Método para autentificar o servidor a ser usado e assim poder redirecionar para a url correta
     * @param string $url Rota para navegação
     * @return string URL correta
     */
    public static function localhost (): bool
    {
        $server = filter_input(INPUT_SERVER, 'SERVER_NAME');
        if($server === 'localhost')
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public static function url(string $url = null) :string
    {
        $server = filter_input(INPUT_SERVER, 'SERVER_NAME');
        $ambiente = ($server === 'localhost' ? URL_DESENVOLVIMENTO : URL_ONLINE);
    
        if(str_starts_with($url, '/'))
        {
            return $ambiente.$url;
        }
    
        return $ambiente.'/'.$url;
    }
    
    public static function dataFormat (): string
    {
        $diaMes = date('d');
        $diaSemana = date('w');
        $mes = date('n') - 1;
        $ano = date('Y');
    
        $diaSemanaArr = ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado'];
    
        $mesesArr = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'
        ];
    
        $dataFormat = $diaSemanaArr[$diaSemana].', '. $diaMes.' de '.$mesesArr[$mes].' de '.$ano;
        return $dataFormat;
    }
    public static function dateNew(): string 
    {
        $data = date('d-m-Y');
        return str_replace('-', '/', $data);
    } 
    
    public static function urlSlug (string $txt): string
    {
        $nova_string = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$txt);
    
        $caractsStr = str_replace(['?', '/','[ˆ0-99]h', ':', ';', '+', '=', '-', '_', '|'], '', $nova_string); 
        
        $slug = strip_tags(trim($caractsStr));
        $sludReplace = str_replace(' ', '+', $slug);
        $sludReplace2 = str_replace(array('+++++', '++++', '++', '+'), '+', $sludReplace);
    
        return strtolower(utf8_decode($sludReplace2));
    }

    public static function filterStr (string $txt): string
    {
        return filter_var($txt, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public static function corOrcamento($id)
    {
        $idInt = intval($id);
        $query = "SELECT * FROM cor WHERE id = '". $idInt ."'";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result;
    }

    public static function investService($id_orcamento)
    {
        $idInt = intval($id_orcamento);
        $query = "SELECT invest_service FROM lucro_orcamento WHERE id_orcamento = $idInt";
        $result = Connection::getInstancia()->query($query)->fetchAll();
        return $result[0]->invest_service;
    }

    public static function mostraNomeCliente($id_orcamento)
    {
        $idInt = intval($id_orcamento);
        $query1 = "SELECT id_cliente FROM orcamentos WHERE id = $idInt";
        $result1 = Connection::getInstancia()->query($query1)->fetchAll();

        $idIntCliente = intval($result1[0]->id_cliente);
        $query2 = "SELECT nome FROM clientes WHERE id = $idIntCliente";
        $result2 = Connection::getInstancia()->query($query2)->fetchAll();
        return $result2[0]->nome;
    }

    public static function verificarInternet()
    {
        // Retorna a URL do ambiente: https://localhost/meusite Ou https://meusite.com/
        $url = self::url();

        $headers = @get_headers($url);

        if ($headers && isset($headers[0])) {
            $statusCode = intval(substr($headers[0], 9, 3));
            if ($statusCode === 200 || $statusCode === 302) {
                // A conexão foi estabelecida, há conexão com a Internet
                return 'ok';
            }
        }

        // A conexão falhou, não há conexão com a Internet
        return 'erro';
    }

    public static function apenNumber($string) {
        // Verifica se a string contém apenas números
        return preg_match('/^[0-9]+$/', $string) === 1;
    }

    public static function validarCPF($cpf) {
        // Remover caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
    
        // Verificar se o CPF possui 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }
    
        // Verificar se todos os dígitos são iguais, o que não é um CPF válido
        if (preg_match('/^(\d)\1*$/', $cpf)) {
            return false;
        }
    
        // Calcula o primeiro dígito verificador
        for ($i = 9, $j = 0, $soma = 0; $i > 0; $i--, $j++) {
            $soma += $cpf[$j] * $i;
        }
        $resto = $soma % 11;
        $digito1 = ($resto < 2) ? 0 : 11 - $resto;
    
        // Verifica o primeiro dígito verificador
        if ($cpf[9] != $digito1) {
            return false;
        }
    
        // Calcula o segundo dígito verificador
        for ($i = 10, $j = 0, $soma = 0; $i > 1; $i--, $j++) {
            $soma += $cpf[$j] * $i;
        }
        $resto = $soma % 11;
        $digito2 = ($resto < 2) ? 0 : 11 - $resto;
    
        // Verifica o segundo dígito verificador
        if ($cpf[10] != $digito2) {
            return false;
        }
    
        return true;
    }
    
        public static function validarCNPJ($cnpj) {
        // Remover caracteres não numéricos
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
    
        // Verificar se o CNPJ possui 14 dígitos
        if (strlen($cnpj) != 14) {
            return false;
        }
    
        // Verificar se todos os dígitos são iguais, o que não é um CNPJ válido
        if (preg_match('/^(\d)\1*$/', $cnpj)) {
            return false;
        }
    
        // Calcula o primeiro dígito verificador
        $soma = 0;
        $multiplicador = 5;
        for ($i = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $multiplicador;
            $multiplicador = ($multiplicador == 2) ? 9 : $multiplicador - 1;
        }
        $resto = $soma % 11;
        $digito1 = ($resto < 2) ? 0 : 11 - $resto;
    
        // Verifica o primeiro dígito verificador
        if ($cnpj[12] != $digito1) {
            return false;
        }
    
        // Calcula o segundo dígito verificador
        $soma = 0;
        $multiplicador = 6;
        for ($i = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $multiplicador;
            $multiplicador = ($multiplicador == 2) ? 9 : $multiplicador - 1;
        }
        $resto = $soma % 11;
        $digito2 = ($resto < 2) ? 0 : 11 - $resto;
    
        // Verifica o segundo dígito verificador
        if ($cnpj[13] != $digito2) {
            return false;
        }
    
        return true;
    }

}

?>