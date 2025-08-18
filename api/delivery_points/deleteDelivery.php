<?php 

header('Content-Type: application/json; charset=UTF-8');
require_once('../../includes/delivery_points.class.php');

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    
    // Obtener id desde la query string
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if (empty($id)) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => "El id del Punto de entrega es obligatorio"
        ]);
        exit;
    }

    $result = DeliveryPoints::delete_delivery_by_id($id);

    if ($result) {
        http_response_code(200);
        echo json_encode([
            "success" => true,
            "message" => "Punto de entrega eliminada correctamente"
        ]);
    } else {
        http_response_code(500);
        echo json_encode([
            "success" => false,
            "message" => "Error al eliminar el Punto de entrega "
        ]);
    }

    exit;
}
?>
