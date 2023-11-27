<?php 
namespace App\Controller\Pages;


use \App\Utils\View;
use \App\Model\Entity\Testimony as EntityTestimony;
use \WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page{
    /**
     * Método responsavel  por obter a renderização dos itens do depoimentos para a pagina
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */

    private static function getTesTimonyItems($request,&$obPagination){
        //DEPOIMENTOS
        $itens = '';

        //QUANTIDADE TOTAL DE REGISTRO
        $quantidadeTotal= EntityTestimony::getTestimonies(null,null,null,'COUNT(*) as qtd')->fetchObject()->qtd;

        //PAGINA ATUAL
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1; 

        //INSTANCIA A PAGINA
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 3);

        //RESULTADO DA PAGINATION
        
        // echo "<pre>";
        // print_r($paginaAtual);
        // echo "</pre>";
        // exit;

        //RESULTADO DA PAGINA
        $results = EntityTestimony::getTestimonies(null,'id DESC',$obPagination->getLimit());

        //RENDERIZA O ITEN
        while($obTestimony =$results->fetchObject(EntityTestimony::class)){
           $itens.= View::render('pages/testimony/item', [
              'nome' => $obTestimony->nome,
              'mensagem' => $obTestimony->mensagem,
              'data' => date('d/m/Y H:i:s',strtotime($obTestimony->data))


            ]);
        

        }


        //RETORNA OS DEPOIMENTOS
        return $itens;

    }

    
    public static function getTestimonies($request){
        /**
         * Método responsavel por retorna a conteudo (view) de depoimentos
         * @return string 
         */
       // $organization = new Organization;
        
        $content = View::render('pages/testimonies',[
            'itens' => self::getTestimonyItems($request,$obPagination),
            'pagination' => parent::getPagination($request,$obPagination)
          
        ]);

        return parent::getPage('FDEV > DEPOIMENTOS', $content);

    }
    /**
     * Metodo responsavel por um depoimento
     *
     * @param  $request
     * @return string
     */
    public static function insertTestimony($request){
        //DADOS DO POST
        $postVars = $request->getPostVars() ;
        //NOVA INSTANCIA DE DEPOIMENTO
        $obTestimony = new EntityTestimony();
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->cadastrar();
       
        //RETORNA A PAGINA DE LISTAGEM DEPOIMENTOS
        return self::getTestimonies($request);

    }






}



?>