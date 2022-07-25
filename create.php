<?php

include_once('../confirmation/environment.php');
include_once('../confirmation/database.php');

$request = json_decode(file_get_contents('php://input'));

if($request->codusuario != null && $request->totalpagar != null && $request->minpagar != null && $request->numusuario != null && $request->fecoportuno != null && $request->fecsuspension != null && $request->ciclo != null && $request->usuario != null && $request->contrasena)
{
    $query = "INSERT INTO bills(codusuario, dirpredio, totalpagar, minpagar, pagado, numfactura, numusuario, fecoportuno, fecsuspension, mesesvencidos, ciclo, usuario, contrasena) VALUES ('$request->codusuario', '$request->dirpredio', '$request->totalpagar', '$request->minpagar', '$request->pagado', '$request->numfactura', '$request->numusuario', '$request->fecoportuno', '$request->fecsuspension', '$request->mesesvencidos', '$request->ciclo', '$request->usuario', '$contrasena')";

    $db = new database();

    $result = $db->saveData($query);

    if($result == 1)
    {
        http_response_code(201);
        $response = array(
            'status' => 'true',
            'message' => 'Factura creada correctamente'
        );
    }else{
        http_response_code(209);
        $response = array(
            'status' => 'true',
            'message' => 'Falló la creacion de la factura'
        );
    }

}else{
    http_response_code(406);
    $response = array(
        'status' => 'ok',
        'message' => 'No cumple con la estructura de datos solicitada'
    );
}

echo json_encode($response);