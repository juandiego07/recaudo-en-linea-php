<?php

include_once('../confirmation/environment.php');
include_once('../confirmation/database.php');
$response = array(
    'status' => 'true',
    'message' => '',
    'data' => array()
);

if($_SERVER['REQUEST_METHOD'] == 'GET') 
{
    if(isset($_GET['numfactura']) && $_GET['numfactura'] != null)
    {
        $numfactura = $_GET['numfactura'];
        $query = "SELECT codusuario, dirpredio, totalpagar, minpagar, pagado, numfactura, numusuario, fecoportuno, fecsuspension, mesesvencidos, ciclo, actualizado, usuario, contrasena FROM bills WHERE numfactura = $numfactura";
        $db = new database();
        $result = $db->saveData($query);        
        if (mysqli_num_rows($result) > 0)
        {
            while ($row = mysqli_fetch_object($result)) {
                array_push($response['data'], $row);
            }
            if($response['data']['0']->pagado == 'NO')
            {
                http_response_code(200);
                $response['message'] = 'Factura encontrada';
                echo json_encode($response['data']);
            }else{
                http_response_code(201);
                $response['message'] = 'Factura cancelada';
                echo json_encode($response);
            }

        }else{
            http_response_code(404);
            $response['message'] = 'Factura no encontrada';
            echo json_encode($response);
        }
    }else{
        http_response_code(200);
        $response['message'] = "Parametro 'numfactura' es requerido";
        echo json_encode($response);
    }
}else{
    http_response_code(405);
    $response['message'] = 'Método no permitido';
    echo json_encode($response);
}