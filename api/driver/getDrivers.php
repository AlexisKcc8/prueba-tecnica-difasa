<?php 

header('Content-Type: application/json; charset=UTF-8');

require_once('../controllers/DriverController.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Obtener las rutas de la base de datos
    $resultDrivers = DriversController::get_all_drivers();

    // Enviar encabezado 200 OK
    http_response_code(200);

    // Responder con los datos
    echo json_encode([
        "success" => true,
        "data" => $resultDrivers,
        "message" => "Choferes obtenidos correctamente"
    ]);
    exit;
}

?>
