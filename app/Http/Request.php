<?php 

namespace App\Http;

class Request{
    private $router;
    private $httpMethod;

    private $uri;

    private $queryParams = [];

    private $postVars = [];

    private $headers = [];   
    public function __construct($router)
{
    $this->router = $router;
    $this->queryParams = $_GET ?? [];
    $this->postVars = $_POST ?? [];
    $this->headers = getallheaders();
    $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
    $this->setUri();
    
    


}
/**
 * Método responsável por definir a URI
 *
 * @return void
 */
private function setUri(){
    //URI completa (com GETS)
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    //remove gets da URI
    $xURI = explode('?', $this->uri);
    $this->uri = $xURI[0];

    // echo"<pre>";
    // print_r($xURI);
    // echo"</pre>";exit;


}
/**
 * Metodo responsavel por retorna a instancia de Router
 * @return Router
 *
 * @return void
 */
public function getRouter(){
    return $this->router;
}
public function getHttpMethod(){
    return $this->httpMethod;
}
public function getUri(){
    return $this->uri;
}
public function getQueryParams(){
    return $this->queryParams;
}
public function getPostVars(){
    return $this->postVars;
}
public function getHeaders(){
    return $this->headers;
}




}



