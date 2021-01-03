<?php
namespace App\Session;

class Login{

    /**
     * Método responsável por iniciar a sessão, verificando se uma já existe ou não     
     */
    private static function init(){

        //CASO NÃO EXISTA UMA SESSÃO ATIVA, VERIFICANDO O STATUS
        if(session_status() !== PHP_SESSION_ACTIVE){
            session_start();
        }

    }

    public static function getUsuarioLogado(){
        //INICIA A SESSÃO
        self::init();

        //RETORNA OS DADOS DO USUÁRIO
        return self::isLogged() ? $_SESSION['usuario'] : null;
    }

    /**
     * Método responsável por logar o usuário
     *
     * @param   Usuario  $obUsuario  [$obUsuario description]
     */
    public static function Login($obUsuario){
        //INICIA A SESSÃO
        self::init();

        $_SESSION['usuario'] = [
            'id' => $obUsuario->id,
            'nome' => $obUsuario->nome,
            'email' => $obUsuario->email
        ];

        //REDIRECIONANDO O USUÁRIO PARA A INDEX
        header('location: index.php');
        exit;
    }

    public static function logout(){
        //INICIA A SESSÃO
        self::init();

        //REMOVENDO A SESSÃO DO USUÁRIO
        unset($_SESSION['usuario']);

        //REDIRECIONANDO USUÁRIO PARA O LOGIN
        header('location: login.php');
        exit;
    }

    /**
     * Método responsável por verificar se o usuário está logado
     *
     * @return  boolean  [return description]
     */
    public static function isLogged(){
        
        //INICIA A SESSÃO
        self::init();
        
        //VALIDAÇÃO DA SESSÃO
        return isset($_SESSION['usuario']['id']);
    }

    /**
     * Método responsável por obrigar o usuário a estar logado para acessar
     */
    public static function requireLogin(){
        if(!self::isLogged()){
            header('location: login.php');
            exit;
        }
    }

    /**
     * Método responsável por obrigar o usuário a estar des-logado para acessar
     */
    public static function requireLogout(){
        if(self::isLogged()){
            header('location: index.php');
            exit;
        }
    }
}