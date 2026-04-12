<?php
// Autor: Cruz - Desarrollo Web Avanzado
// Dr. José Alfonso Aguilar Calderón

require_once __DIR__ . '/../models/Futbolista.php';

class FutbolistaController {
    private $db;
    private $futbolista;

    public function __construct($db) {
        $this->db = $db;
        $this->futbolista = new Futbolista($db);
    }

    // GET /futbolistas
    public function getAll() {
        $stmt = $this->futbolista->getAll();
        $data = $stmt->fetchAll();

        http_response_code(200);
        echo json_encode([
            'success' => true,
            'count'   => count($data),
            'data'    => $data
        ]);
    }

    // GET /futbolistas/{id}
    public function getById($id) {
        $this->futbolista->id = (int) $id;
        $stmt = $this->futbolista->getById();
        $data = $stmt->fetch();

        if (!$data) {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'message' => 'Futbolista no encontrado.'
            ]);
            return;
        }

        http_response_code(200);
        echo json_encode([
            'success' => true,
            'data'    => $data
        ]);
    }

    // POST /futbolistas
    public function create() {
        $body = json_decode(file_get_contents('php://input'), true);

        if (!$body) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Cuerpo de la petición inválido o vacío.']);
            return;
        }

        // Validar campos requeridos
        $required = ['nombre', 'posicion', 'numero', 'edad', 'equipo'];
        foreach ($required as $field) {
            if (!isset($body[$field]) || $body[$field] === '') {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => "El campo '$field' es obligatorio."]);
                return;
            }
        }

        // Validaciones de negocio
        if (!is_numeric($body['edad']) || (int)$body['edad'] < 0 || (int)$body['edad'] > 99) {
            http_response_code(422);
            echo json_encode(['success' => false, 'message' => 'La edad debe ser un número entre 0 y 99.']);
            return;
        }

        if (!is_numeric($body['numero']) || (int)$body['numero'] < 1 || (int)$body['numero'] > 99) {
            http_response_code(422);
            echo json_encode(['success' => false, 'message' => 'El número de camiseta debe ser entre 1 y 99.']);
            return;
        }

        $this->futbolista->nombre   = $body['nombre'];
        $this->futbolista->posicion = $body['posicion'];
        $this->futbolista->numero   = $body['numero'];
        $this->futbolista->edad     = $body['edad'];
        $this->futbolista->equipo   = $body['equipo'];

        if ($this->futbolista->create()) {
            $this->futbolista->id = $this->futbolista->id;
            $stmt = $this->futbolista->getById();
            $data = $stmt->fetch();

            http_response_code(201);
            echo json_encode([
                'success' => true,
                'message' => 'Futbolista creado exitosamente.',
                'data'    => $data
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error al crear el futbolista.']);
        }
    }

    // PUT /futbolistas/{id}
    public function update($id) {
        $this->futbolista->id = (int) $id;

        if (!$this->futbolista->exists()) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Futbolista no encontrado.']);
            return;
        }

        $body = json_decode(file_get_contents('php://input'), true);

        if (!$body) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Cuerpo de la petición inválido o vacío.']);
            return;
        }

        // Validar campos requeridos
        $required = ['nombre', 'posicion', 'numero', 'edad', 'equipo'];
        foreach ($required as $field) {
            if (!isset($body[$field]) || $body[$field] === '') {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => "El campo '$field' es obligatorio."]);
                return;
            }
        }

        // Validaciones de negocio
        if (!is_numeric($body['edad']) || (int)$body['edad'] < 0 || (int)$body['edad'] > 99) {
            http_response_code(422);
            echo json_encode(['success' => false, 'message' => 'La edad debe ser un número entre 0 y 99.']);
            return;
        }

        if (!is_numeric($body['numero']) || (int)$body['numero'] < 1 || (int)$body['numero'] > 99) {
            http_response_code(422);
            echo json_encode(['success' => false, 'message' => 'El número de camiseta debe ser entre 1 y 99.']);
            return;
        }

        $this->futbolista->nombre   = $body['nombre'];
        $this->futbolista->posicion = $body['posicion'];
        $this->futbolista->numero   = $body['numero'];
        $this->futbolista->edad     = $body['edad'];
        $this->futbolista->equipo   = $body['equipo'];

        if ($this->futbolista->update()) {
            $stmt = $this->futbolista->getById();
            $data = $stmt->fetch();

            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Futbolista actualizado exitosamente.',
                'data'    => $data
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el futbolista.']);
        }
    }

    // DELETE /futbolistas/{id}
    public function delete($id) {
        $this->futbolista->id = (int) $id;

        if (!$this->futbolista->exists()) {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Futbolista no encontrado.']);
            return;
        }

        if ($this->futbolista->delete()) {
            http_response_code(200);
            echo json_encode([
                'success' => true,
                'message' => 'Futbolista eliminado exitosamente.'
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error al eliminar el futbolista.']);
        }
    }
}
