<?php 

header('Content-Type: application/json; charset=UTF-8');

require_once('../../includes/delivery_points.class.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Obtener las rutas de la base de datos
    $result = DeliveryPoints::get_all_deliverys();

    // Enviar encabezado 200 OK
    http_response_code(200);

    // Responder con los datos
    echo json_encode([
        "success" => true,
        "data" => $result,
        "message" => "Choferes obtenidos correctamente"
    ]);
    exit;
}

?>
