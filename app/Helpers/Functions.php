<?php
function send_response($message, $data)
{

    $response = [
        'status' => true,
        'message' => $message,
        'data' => $data,
    ];

    return response()->json([$response]);
}




/**
 * @param $message
 * @param array $message
 * @param int $code
 */
function send_error($message, $messages = [], $code = 404)
{

    $response = [
        'status' => false,
        'message' => $message
    ];

    !empty($messages) ? $response['message'] = $message : null;

    return response()->json([$response], $code);
}