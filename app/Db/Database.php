<?php
//UTILIZAÇÃO DO CONCEITO DE QUERY BUILDER

namespace App\Db;

//DEFININDO O PDO COMO UMA "DEPENDẼNCIA" DA CLASSE
use \PDO;
use \PDOException;

class Database{
    //CREDENCIAIS DE ACESSO AO BD
    const HOST = '127.0.0.1';
    const NAME = 'db_neoworks';
    const USER = 'root';
    const PASS = '';

    /**
     * Nome da tabela a ser manipulada
     * @var string
     */
    private $table;

    /**
     * Instância de coneão com o BD
     * @var PDO
     */
    private $connection;

    /**
     * Definindo a tabela a ser usada no momento do instanciamento (ao ser chamada)
     * por isso o __construct (método construtor)
     * @var string $table
     */
    public function __construct($table = null){
        $this->table = $table;
        $this->setConnection();
    }

    /**
     * Método responsável por criar uma conexão com o BD
     */
    private function setConnection(){
        //INSTANCIANDO UMA CONEXÃO PDO
        try{
            $this->connection = new PDO('mysql:host='.self::HOST.';dbname='.self::NAME,self::USER,self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);            
        }catch(PDOException $e){
            die('ERROR: '.$e->getMessage());
        }
    }

    /**
     * Método responsável por executar as queries dentro do BD
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    public function execute($query, $params = []){
        try{
            $statement = $this->connection->prepare($query);
            $statement->execute($params);

            return $statement;
        }catch(PDOException $e){
            die('ERROR: '.$e->getMessage());
        }
    }

    /**
     * Método responsável por inserir dados no BD
     * @param array $values [ field => value ]
     * @return integer (ID inserido)
     */
    public function insert($values){
        //DADOS DA QUERY
        $fields = array_keys($values);
        /**
         * definindo a quantidade de valores do array com os dados
         */
        $binds = array_pad([], count($fields), '?');

        //MONTA A QUERY
        $query = 'INSERT INTO '.$this->table.' ('.implode(',', $fields).') VALUES ('.implode(',', $binds).')';
        
        //EXECUTA A QUERY
        $this->execute($query, array_values($values));

        //RETORNA O ID INSERIDO (ÚLTIMO)
        return $this->connection->lastInsertId();
    }

    /**
     * Método responsável por executar uma consulta ao BD
     *
     * @param   string  $where   [$where description]
     * @param   string  $order   [$order description]
     * @param   string  $limit   [$limit description]
     * @param   string  $fields  [$fields description]     
     *
     * @return  PDOStatement     [return values]
     */
    public function select($where = null, $order = null, $limit = null, $fields = '*'){
        //DADOS DA QUERY
        $where = strlen($where) ? 'WHERE '.$where : '';
        $order = strlen($order) ? 'ORDER BY '.$order : '';
        $limit = strlen($limit) ? 'LIMIT '.$limit : '';

        //MONTAGEM DA QUERY
        $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

        //EXECUÇÃO DA QUERY
        return $this->execute($query);

    }

    public function update($where,$values){
        //DADOS DA QUERY
        $fields = array_keys($values);

        //MONTA QUERY
        $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;        

        //EXECUÇÃO DA QUERY
        $this->execute($query,array_values($values));

        return true;
    }

    /**
     * Método responsável por realizar a exlusão dos dados do BD
     *
     * @param   integer  $where  [$where description]
     *
     * @return  boolean          [return description]
     */
    public function delete($where){
        //MONTA A QUERY
        $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

        //EXECUTA A QUERY
        $this->execute($query);

        //RETORNA SUCESSO
        return true;
    }
}