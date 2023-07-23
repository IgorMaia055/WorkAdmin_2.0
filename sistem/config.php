<?php

// função para informar o fuso horário de são paulo

date_default_timezone_set('America/Sao_paulo');

//Constantes para conexão com banco de dados
define('HOST', 'localhost');
define('DB_NAME', 'workadmin');
define('USER', 'root');
define('PASS', '');

define('NOME_SITE', 'WorkAdmin');
define('URL_ONLINE', 'https://zambianktecnologias.com.br/WorkAdmin');
define('URL_DESENVOLVIMENTO', 'http://localhost/WorkAdmin_2.0');
define('ROUTER_BASE', 'WorkAdmin_2.0/');

define('ENDPOINT', 'https://sandbox.api.pagseguro.com/orders');
define('TOKEN', 'F06323705C3F4B0E882A02B453E31946');
const NAME = 'Igor Maia';
?>