<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 15/02/2024
    Modulo: DWES
    UD: 04
    Clase VehiculoCrearDTO 
    Es una clase  que sirve para encapsular todos los datos empleados para crar un vehículo
*/ 
class VehiculoCrearDTO implements JsonSerializable{
    private $marca;
    private $modelo;
    private $kilometros;
    private $year;
    private $clase;
    private $disponible;
    private $prestado;
    private $fecha_inicio;
    private $fecha_fin;
    private $usuario_id;
    private $revision;
    private $id;
    private $capacidad;
    private $electrico;
    private $cuatro_por_cuatro;
    
    
    public function __construct($clase, $datos) {
        $this->marca = $datos['marca'];
        $this->modelo = $datos['modelo'];
        $this->kilometros = $datos['kilometros'];
        $this->year = $datos['year'];
        $this->clase = $datos['clase'];
        $this->disponible = $datos['disponible'];
        $this->prestado = $datos['prestado'];
        $this->fecha_inicio = $datos['fecha_inicio'];
        $this->fecha_fin = $datos['fecha_fin'];
        $this->usuario_id = $datos['usuario_id'];
        $this->revision = $datos['revision'];
        $this->id = $datos['id'];
        if ($clase == 'furgoneta') {
            $this->capacidad = $datos['capacidad'];
        } elseif ($clase == 'todoterreno') {
            $this->electrico = $datos['cuatro_por_cuatro'];
        } elseif ($clase == 'turismo') {
            $this->cuatro_por_cuatro = $datos['electrico'];
        }
    }
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

    /**
     * Get the value of marca
     */
    public function getMarca()
    {
        return $this->marca;
    }


    /**
     * Get the value of modelo
     */
    public function getModelo()
    {
        return $this->modelo;
    }



    /**
     * Get the value of kilometros
     */
    public function getKilometros()
    {
        return $this->kilometros;
    }



    /**
     * Get the value of year
     */
    public function getYear()
    {
        return $this->year;
    }


    /**
     * Get the value of clase
     */
    public function getClase()
    {
        return $this->clase;
    }



    /**
     * Get the value of disponible
     */
    public function getDisponible()
    {
        return $this->disponible;
    }



    /**
     * Get the value of prestado
     */
    public function getPrestado()
    {
        return $this->prestado;
    }



    /**
     * Get the value of fecha_inicio
     */
    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }



    /**
     * Get the value of fecha_fin
     */
    public function getFechaFin()
    {
        return $this->fecha_fin;
    }



    /**
     * Get the value of usuario_id
     */
    public function getUsuarioId()
    {
        return $this->usuario_id;
    }



    /**
     * Get the value of revision
     */
    public function getRevision()
    {
        return $this->revision;
    }



    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }



    /**
     * Get the value of capacidad
     */
    public function getCapacidad()
    {
        return $this->capacidad;
    }
    /**
     * Get the value of electrico
     */
    public function getElectrico()
    {
        return $this->electrico;
    }

    /**
     * Get the value of cuatro_por_cuatro
     */
    public function getCuatro_por_cuatro()
    {
        return $this->cuatro_por_cuatro;
    }

}

?>