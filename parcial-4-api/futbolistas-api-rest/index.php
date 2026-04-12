<?php

header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}


require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/FutbolistaController.php';


$database = new Database();
$db = $database->getConnection();


$controller = new FutbolistaController($db);


$requestUri    = $_SERVER['REQUEST_URI'];
$scriptName    = dirname($_SERVER['SCRIPT_NAME']);
$path          = str_replace($scriptName, '', $requestUri);
$path          = strtok($path, '?');         
$path          = rtrim($path, '/');           
$segments      = explode('/', ltrim($path, '/'));
$method        = $_SERVER['REQUEST_METHOD'];



if ($segments[0] === 'futbolistas') {
    $id = isset($segments[1]) && is_numeric($segments[1]) ? $segments[1] : null;

    switch ($method) {
        case 'GET':
            if ($id) {
                $controller->getById($id);
            } else {
                $controller->getAll();
            }
            break;

        case 'POST':
            $controller->create();
            break;

        case 'PUT':
            if ($id) {
                $controller->update($id);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Se requiere un ID para actualizar.']);
            }
            break;

        case 'DELETE':
            if ($id) {
                $controller->delete($id);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Se requiere un ID para eliminar.']);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
            break;
    }
} else {
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'message' => 'Ruta no encontrada.',
        'endpoints_disponibles' => [
            'GET    /futbolistas'       => 'Obtener todos los futbolistas',
            'GET    /futbolistas/{id}'  => 'Obtener un futbolista por ID',
            'POST   /futbolistas'       => 'Crear un nuevo futbolista',
            'PUT    /futbolistas/{id}'  => 'Actualizar un futbolista',
            'DELETE /futbolistas/{id}'  => 'Eliminar un futbolista'
        ]
    ]);
}
