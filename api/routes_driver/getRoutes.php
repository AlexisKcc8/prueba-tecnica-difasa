<?php 

header('Content-Type: application/json; charset=UTF-8');

require_once('../../includes/routes.class.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Obtener las rutas de la base de datos
    $result = Routes::get_all_routes();

    // Enviar encabezado 200 OK
    http_response_code(200);

    // Responder con los datos
    echo json_encode([
        "success" => true,
        "data" => $result,
        "message" => "Rutas obtenidas correctamente"
    ]);
    exit;
}

?>
