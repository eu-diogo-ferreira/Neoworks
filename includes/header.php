<?php

use \App\Session\Login;

$usuarioLogado = Login::getUsuarioLogado();

$usuario = $usuarioLogado ? 
                        $usuarioLogado['nome'].' <a href="logout.php" class="text-light font-weight-bold ml-2">Sair</a>' : 
                        'Visitante <a href="login.php" class="text-light font-weight-bold ml-2">Entrar</a>';



?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1 shrik-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>NeoWorks</title>    
</head>

<body class="bg-dark text-light">
    <!-- CONTAINER -->
    <div class="container">

        <div class="jumbotron bg-danger my-2">
            <h1>NeoWorks</h1>

            <hr class="border-light">

            <div class="d-flex justify-content-start">
                <?=$usuario;?>
            </div>
        </div>