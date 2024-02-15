<?php
require_once __DIR__.'/../app/model/DAO/VehiculoDAO.php';
/*
    Autor:Jesus Diego Rivero
    Fecha: 21/12/2023
    Modulo: DWES
    UD: 03
    Se establecen las rutas
*/  
// clase donde se establecen las rutas y se comparan
class Router {

    protected $routes = array();
    protected $params =array();
    public function add($route, $params)
    {
        $this->routes[$route] = $params;
    }

    public function getRoutes()
    {
        return $this->routes;
    }
    // se detrmina la coincidencia  según la solicitud recibida
    public function matchRoute($url) {
        // obtengo los registros existentes
        $bbddObject = new VehiculoDAO();
        $bbddArray=$bbddObject->obtenerVehiculos();
        //creo un array para  los id de los registros que existen
        $listaId = array('furgoneta', 'todoterreno', 'turismo', 'alquilado');
        foreach ($bbddArray as $object) {
                $listaId[] = $object->getPropiedad_id();
        }
        // transformo el array en un string para aplicarlo al patron.
        // Asi sólo busca coinicdencias con los id que existen
        $rango = implode('|', $listaId);
        foreach ($this->routes as $route => $params) 
        {
            $pattern = str_replace(['{id}', '/'], ['('.$rango.')', '\/'], $route);
            $pattern = '/^'.$pattern.'$/';
            if(preg_match($pattern, $url['path'])) {
                $this->params=$params;
                return true;
            }
        }
        return false;
    }
    public function getParams() {
        return $this->params;
    }
}