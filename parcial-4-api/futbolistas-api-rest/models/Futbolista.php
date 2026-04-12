<?php
// Autor: Cruz - Desarrollo Web Avanzado
// Dr. José Alfonso Aguilar Calderón

class Futbolista {
    private $conn;
    private $table = 'futbolistas';

    public $id;
    public $nombre;
    public $posicion;
    public $numero;
    public $edad;
    public $equipo;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Obtener todos los futbolistas
    public function getAll() {
        $query = "SELECT id, nombre, posicion, numero, edad, equipo, created_at, updated_at 
                  FROM {$this->table} 
                  ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Obtener un futbolista por ID
    public function getById() {
        $query = "SELECT id, nombre, posicion, numero, edad, equipo, created_at, updated_at 
                  FROM {$this->table} 
                  WHERE id = :id 
                  LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }

    // Crear un nuevo futbolista
    public function create() {
        $query = "INSERT INTO {$this->table} (nombre, posicion, numero, edad, equipo) 
                  VALUES (:nombre, :posicion, :numero, :edad, :equipo)";
        $stmt = $this->conn->prepare($query);

        $this->sanitize();

        $stmt->bindParam(':nombre',   $this->nombre);
        $stmt->bindParam(':posicion', $this->posicion);
        $stmt->bindParam(':numero',   $this->numero, PDO::PARAM_INT);
        $stmt->bindParam(':edad',     $this->edad,   PDO::PARAM_INT);
        $stmt->bindParam(':equipo',   $this->equipo);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    // Actualizar un futbolista
    public function update() {
        $query = "UPDATE {$this->table} 
                  SET nombre = :nombre, posicion = :posicion, numero = :numero, 
                      edad = :edad, equipo = :equipo 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->sanitize();

        $stmt->bindParam(':id',       $this->id,     PDO::PARAM_INT);
        $stmt->bindParam(':nombre',   $this->nombre);
        $stmt->bindParam(':posicion', $this->posicion);
        $stmt->bindParam(':numero',   $this->numero, PDO::PARAM_INT);
        $stmt->bindParam(':edad',     $this->edad,   PDO::PARAM_INT);
        $stmt->bindParam(':equipo',   $this->equipo);

        return $stmt->execute();
    }

    // Eliminar un futbolista
    public function delete() {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Verificar si existe el futbolista
    public function exists() {
        $query = "SELECT id FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    // Sanitizar entradas
    private function sanitize() {
        $this->nombre   = htmlspecialchars(strip_tags(trim($this->nombre)));
        $this->posicion = htmlspecialchars(strip_tags(trim($this->posicion)));
        $this->equipo   = htmlspecialchars(strip_tags(trim($this->equipo)));
        $this->numero   = (int) $this->numero;
        $this->edad     = (int) $this->edad;
    }
}
