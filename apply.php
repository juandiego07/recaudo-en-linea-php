<?php

include_once('../confirmation/environment.php');
include_once('../confirmation/database.php');
$response = array(
    'status' => 'true',
    'message' => '',
    'data' => array()
);

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $numfactura = $_REQUEST['x_id_factura'];
    $query = "SELECT * FROM bills WHERE numfactura = $numfactura";
    $db = new database();
    $result = $db->saveData($query);

    if (mysqli_num_rows($result) > 0) {

        $data = mysqli_fetch_object($result);

        if ($data->totalpagar == $_REQUEST['x_amount'] && $data->pagado != 'CANCELADA' && $_REQUEST['x_transaction_state']  == 'Aceptada') {

            $query = "UPDATE bills SET pagado = 'CANCELADA' WHERE numfactura = $numfactura";
            $result = $db->saveData($query);

            if ($result == 1) {
                $response['message'] = 'Pago aplicado';
            } else {
                $response['message'] = 'Pago no aplicado';
            }
        } else {
            $response['message'] = 'Datos incorrectos, no es posible aplicar el pago';
        }
        http_response_code(200);
    } else {

        $response['message'] = 'Factura no encontrada';
        http_response_code(201);
    }
}else{
    $response['message'] = 'Metodo no permitido';
    http_response_code(405);
}

echo json_encode($response);
