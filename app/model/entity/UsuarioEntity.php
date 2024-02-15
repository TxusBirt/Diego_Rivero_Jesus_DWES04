<?php
/*
    Autor:Jesus Diego Rivero
    Fecha: 21/12/2023
    Modulo: DWES
    UD: 03
    Clase Vehiculo padre de las demás
*/  
abstract class UsuarioEntity {
    private $id;
    private $nombre;
    private $departamento;

    // las propiedades se establecen a partir de un array asociativo
    public function __construct($id, $nombre, $departamento)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->departamento = $departamento;
    
    }


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre($nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of departamento
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }

    /**
     * Set the value of departamento
     */
    public function setDepartamento($departamento): self
    {
        $this->departamento = $departamento;

        return $this;
    }
}

?>
