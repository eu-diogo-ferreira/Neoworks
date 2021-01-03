<?php

namespace App\Entity;

//DEFININDO A DEPENDÊNCIA DA CLASSE DE CONEXÃO
use App\Db\Database;
use \PDO;

class Vaga{

    /**
     * Identificador único da vaga
     * @var integer
     */
    public $id;

    /**
     * Título da vaga
     * @var string
     */
    public $titulo;

    /**
     * Descrição da vaga (pode conter html)
     * @var string
     */
    public $descricao;

    /**
     * Define se a vaga está ativa
     * @var string(s/n)
     */
    public $ativo;

    /**
     * Defini a data da vaga
     * @var string
     */
    public $data;

    /**
     * Método responsável por cadastrar uma nova vaga no banco de dados
     * @return boolean
     */
    public function cadastrar(){
        //DEFINIR A DATA
        $this->data = date('Y-m-d H:i:s');
    
        /**
         * Informando qual a tabela está a ser usada
         */
        //INSERINDO A VAGA NO BANCO
        $obDatabase = new Database('vagas');
        /**
         * id = resultado da consulta ao banco
         */
        //ENVIANDO OS DADOS NA FORMA DE UMA ARRAY & ATRIBUINDO O ID DA VAGA NA INSTÂNCIA
        $this->id = $obDatabase->insert([
                                            'titulo' => $this->titulo,
                                            'descricao' => $this->descricao,
                                            'ativo' => $this->ativo,
                                            'data' => $this->data            
                                        ]);
        
        //RETORNAR O SUCESSO
        return true;
    }

    /**
     * Método responsável por atualizar a vaga no BD
     *
     * @return  boolean  [return description]
     */
    public function atualizar(){
        return (new Database('vagas'))->update('id = '.$this->id, [
                                                                    'titulo' => $this->titulo,
                                                                    'descricao' => $this->descricao,
                                                                    'ativo' => $this->ativo,
                                                                    'data' => $this->data            
                                                                    ]);
    }

    /**
     * Método responsável por realizar a exlusão da vaga no BD
     *
     * @return  boolean  [return description]
     */
    public function excluir(){
        return (new Database('vagas'))->delete('id = '.$this->id);
    }

    /**
     * Método responsável por obter as vagas no BD
     *
     * @param   string  $where  [$where description]
     * @param   string  $order  [$order description]
     * @param   string  $limit  [$limit description]
     * @param   string          [ description]
     *
     * @return  array        [return description]
     */
    public static function getVagas($where = null, $order = null, $limit = null){
        return (new Database('vagas'))->select($where,$order,$limit)
                                        ->fetchAll(PDO::FETCH_CLASS,self::class);
    }

    /**
     * Método responsável por obter a quantidade vagas no BD
     *
     * @param   string  $where  [$where description]
     * @param   string  $order  [$order description]
     * @param   string  $limit  [$limit description]
     * @param   string          [ description]
     *
     * @return  array        [return description]
     */
    public static function getQuantidadeVagas($where = null){
        return (new Database('vagas'))->select($where,null,null,'COUNT(*) as qtd')
                                        ->fetchObject()
                                        ->qtd;
    }

    public static function getVaga($id){
        return (new Database('vagas'))->select('id = '.$id)
                                        ->fetchObject(self::class);
    }
}