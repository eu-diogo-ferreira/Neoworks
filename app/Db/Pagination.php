<?php
namespace App\Db;

class Pagination{

    /**
     * Número máximo de registros por página
     *
     * @var integer
     */
    private $limit;

    /**
     * Quantidade total de resultados do BD
     *
     * @var integer
     */
    private $results;

    /**
     * Quantidade de páginas
     *
     * @var integer
     */
    private $pages;

    /**
     * Página atual
     *
     * @var integer
     */
    private $currentPage;

    /**
     * Método contrutor da classe
     *
     * @param   integer  $results      [$results description]
     * @param   integer  $currentPage  [$currentPage description]
     * @param   integer  $limit        [$limit description]
     *
     * @return  [type]                [return description]
     */
    public function __construct($results, $currentPage = 1, $limit = 10){
        $this->results = $results;
        $this->limit = $limit;
        $this->currentPage = (is_numeric($currentPage) and $currentPage > 0) ? $currentPage : 1;
        $this->calculate();
    }

    /**
     * Método responsável por calcular a paginação    
     */
    private function calculate(){
        //CALCULANDO O TOTAL DE PÁGINAS
        $this->pages = $this->results > 0 ? ceil($this->results / $this->limit) : 1;

        //VERIFICANDO SE A PÁGINA ATUAL NÃO EXCEDE O NÚMERO DE PÁGINAS
        $this->currentPage = $this->currentPage <= $this->pages ? $this->currentPage : $this->pages;
    }

    /**
     * Método responsável por retornar a clausula limit do SQL
     *
     * @return  string  [return description]
     */
    public function getLimit(){
        $offset = ($this->limit * ($this->currentPage - 1));
        return $offset.','.$this->limit;
    }

    /**
     * Métoo responsável por retornar as opções de páginas disponíveis
     *
     * @return  array  [return description]
     */
    public function getPages(){
        //NÃO RETORNA PÁGINAS
        if($this->pages == 1) return [];

        //PÁGINAS
        $paginas = [];
        for($i = 1;$i <= $this->pages; $i++){
            $paginas[] = [
                'pagina' => $i,
                'atual' => $i == $this->currentPage
            ];
        }

        return $paginas;
    }
}