<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 15/02/2024
    Modulo: DWES
    UD: 04
    Clase TodoterrenoEntity que hereda de VehiculoEntity
    Define los objetos Todoterreno
*/   
require_once 'VehiculoEntity.php';

class TodoterrenoEntity extends VehiculoEntity {
    //propiedad única de esta clase
    protected $cuatroPorCuatro;

    public function __construct($datos) {
        parent::__construct($datos);
        $this->cuatroPorCuatro = $datos['cuatro_por_cuatro'];
    }
    public function toArray(): array {
        return [
            'marca' => $this->marca,
            'modelo'=>$this->modelo,
            'kilometros'=>$this->kilometros,
            'year'=>$this->year,
            'clase'=>$this->clase,
            'disponible'=>$this->disponible,
            'prestado'=>$this->prestado,
            'fecha_inicio'=>$this->fecha_inicio,
            'fecha_fin'=>$this->fecha_fin,
            'usuario_id'=>$this->usuario_id,
            'revision'=>$this->revision,
            'id'=>$this->id,
            '4x4'=>$this->cuatroPorCuatro
        ];
    }
    public function setPropiedades($datos)
    {
        if (isset($datos['kilometros'])) {
            $this->kilometros = $datos['kilometros'];
        }
        if (isset($datos['disponible']) && $datos['disponible']=='si') {
            $this->disponible = $datos['disponible'];
        //si no está disponible no tienen valor los atributos relacionados
        } elseif (isset($datos['disponible']) && $datos['disponible']=='no') {
            $this->prestado = 'no';
            $this->fecha_inicio = '';
            $this->fecha_fin = '';
            $this->usuario_id = '';
            $this->disponible = $datos['disponible'];
        }
        if (isset($datos['prestado']) && $datos['prestado']=='si') {
            $this->prestado = $datos['prestado'];
        //si no está prestado no tienen valor los atributos relacionados
        } elseif (isset($datos['prestado']) && $datos['prestado']=='no') {
            $this->fecha_inicio = '';
            $this->fecha_fin = '';
            $this->usuario_id = '';
            $this->prestado = $datos['prestado'];
        }
        if (isset($datos['fecha_inicio'])) {
            $this->fecha_inicio = $datos['fecha_inicio'];
        }
        if (isset($datos['fecha_fin'])) {
            $this->fecha_fin = $datos['fecha_fin'];
        }
        if (isset($datos['usuario_id'])) {
            $this->usuario_id = $datos['usuario_id'];
        }
        if (isset($datos['revision']) && $datos['revision']=='si') {
            $this->revision = $datos['revision'];
        //si no está revisado no se puede prestar ni está disponible
        } elseif (isset($datos['revision']) && $datos['revision']=='no') {
            $this->revision = $datos['revision'];
            $this->disponible = 'no';
            $this->prestado = 'no';
            $this->fecha_inicio = '';
            $this->fecha_fin = '';
            $this->usuario_id = '';
        }

    }
    // establece un id nuevo
    public function setPropiedad_id($num) {
        $id = $num + 1;
        $this->id = $id;
        return $this->id;
    }

    public function getPropiedad_id() {
        return $this->id;
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
     * Get the value of cuatroPorCuatro
     */
    public function getCuatroPorCuatro()
    {
        return $this->cuatroPorCuatro;
    }


}
?>