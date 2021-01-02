<?php

include __DIR__."/vendor/autoload.php";

//IMPORTANDO A CLASSE DE VAGAS
use App\Entity\Vaga;

$vagas = Vaga::getVagas();


include __DIR__."/includes/header.php";
include __DIR__."/includes/listagem.php";
include __DIR__."/includes/footer.php";