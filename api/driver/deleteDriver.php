<?php 

header('Content-Type: application/json; charset=UTF-8');
require_once('../controllers/DriverController.php');

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    
    // Obtener id desde la query string
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if (empty($id)) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "El id del chofer es obligatorio"
        ]);
        exit;
    }

    $result = DriversController::delete_driver_by_id($id);

    if ($result) {
        http_response_code(200);
        echo json_encode([
            "success" => true,
            "message" => "Chofer eliminado correctamente"
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Error al eliminar el chofer"
        ]);
    }

    exit;
}
?>
