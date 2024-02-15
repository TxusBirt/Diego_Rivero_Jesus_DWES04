<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 15/02/2024
    Modulo: DWES
    UD: 04
    Clase VehiculoDTO 
    Es una clase general que sirve para encapsular todos los datos relacionados con 
    vehículos
*/  
require_once __DIR__.'/../entity/FurgonetaEntity.php';
require_once __DIR__.'/../entity/TodoterrenoEntity.php';
require_once __DIR__.'/../entity/TurismoEntity.php';
class VehiculoDTO implements JsonSerializable{
    // propiedad que será un objeto
    private $vehiculo;
    
    public function __construct($clase, $datos) {
     
        // Dependiendo del tipo de objeto, inicializamos $vehiculo con una instancia adecuada
        switch ($clase) {
            case 'furgoneta':
                $this->vehiculo = new FurgonetaEntity($datos);
                break;
            case 'turismo':
                $this->vehiculo = new TurismoEntity($datos);
                break;
            case 'todoterreno':
                $this->vehiculo = new TodoterrenoEntity($datos);
                break;
            default:
            throw new Exception("Tipo de vehículo desconocido");
            }
        }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

    /**
     * Get the value of vehiculo
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }

    public function getPropiedad_id() {
        return $this->vehiculo->getPropiedad_id();
    }
   
}

?>