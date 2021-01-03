<?php

include __DIR__."/vendor/autoload.php";

use \App\Entity\Usuario;
use \App\Session\Login;

//OBRIGA O USUÁRIO A NÃO ESTAR LOGADO
Login::requireLogout();

//MENSAGENS DE ALERTA DOS FORMS
$alertaLogin = '';
$alertaCadastro = '';

//VALIDAÇÃO DA EXISTENCIA DO ÍNDICE DE LOGIN/LOGOUT - POST
if(isset($_POST['acao'])){
    switch($_POST['acao']){
        case 'logar':

            //BUSCANDO REGISTROS DO USUÁRIO POR EMAIL
            $obUsuario = Usuario::getUsuarioPorEmail($_POST['email']);

            //VALIDAÇÃO DA EXISTÊNCIA DE REGISTROS
            if(!$obUsuario instanceof Usuario || !password_verify($_POST['senha'],$obUsuario->senha)){
                $alertaLogin = 'Email ou senha inválidos.';
                break;
            }

            //LOGA O USUÁRIO
            Login::login($obUsuario);            
            break;
        
        case 'cadastrar':
            //VALIDAÇÃO DOS CAMPOS OBRIGATÓRIOS
            if(isset($_POST['nome'], $_POST['email'], $_POST['senha'])){

                //BUSCANDO REGISTROS DO USUÁRIO POR EMAIL
                $obUsuario = Usuario::getUsuarioPorEmail($_POST['email']);
                if($obUsuario instanceof Usuario){
                    $alertaCadastro = 'O e-mail cadastrado já está em uso';

                    break;
                }

                //NOVO USUÁRIO
                $obUsuario = new Usuario;
                $obUsuario->nome = $_POST['nome'];
                $obUsuario->email = $_POST['email'];
                //HASH DINÂMICA
                $obUsuario->senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);                                

                $obUsuario->cadastrar();

                //LOGA O USUÁRIO
                Login::login($obUsuario); 
            }            
            break;
    }
}

include __DIR__."/includes/header.php";
include __DIR__."/includes/formulario-login.php";
include __DIR__."/includes/footer.php";