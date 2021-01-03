<?php

include __DIR__."/vendor/autoload.php";

//IMPORTANDO A CLASSE DE VAGAS
use \App\Entity\Vaga;
use \App\Db\Pagination;
use \App\Session\Login;

//OBRIGA O USUÁRIO A ESTAR LOGADO
Login::requireLogin();

//BUSCA
$busca = filter_input(INPUT_GET, 'busca', FILTER_SANITIZE_STRING);

//FILTRO DE STATUS
$filtroStatus = filter_input(INPUT_GET, 'filtroStatus', FILTER_SANITIZE_STRING);
//VALIDANDO O FILTRO PARA APENAS RECEBER 'S/N'
$filtroStatus = in_array($filtroStatus,['s','n']) ? $filtroStatus : '';

//CONDIÇÕES SQL
$condicoes = [
    strlen($busca) ? 'titulo LIKE "%'.str_replace('', '%', $busca).'%"' : null,
    strlen($filtroStatus) ? 'ativo = "'.$filtroStatus.'"' : null
];

//REMOVE POSIÇÕES VAZIAS
$condicoes = array_filter($condicoes);

//CLAUSULUA WHERE
$where = implode(' AND ',$condicoes);

//QUANTIDADE TOTAL DE VAGAS
$quantidadeVagas = Vaga::getQuantidadeVagas($where);

//PAGINAÇÃO
$obPagination = new Pagination($quantidadeVagas, $_GET['pagina'] ?? 1, 5);


$vagas = Vaga::getVagas($where,null,$obPagination->getLimit());


include __DIR__."/includes/header.php";
include __DIR__."/includes/listagem.php";
include __DIR__."/includes/footer.php";