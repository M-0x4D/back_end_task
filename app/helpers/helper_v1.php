<?php


use Illuminate\Support\Facades\Validator;


function json_response($status,$msg , $data=null)
{

    $response = [
        "status" => $status,
        "msg" => $msg , 
        "data" => $data
    ];

    return response()->json($response);
}

?>