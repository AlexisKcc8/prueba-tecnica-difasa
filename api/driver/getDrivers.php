<?php 

header('Content-Type: application/json; charset=UTF-8');

require_once('../../includes/drivers.class.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Obtener las rutas de la base de datos
    $result = Driver::get_all_drivers();

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
