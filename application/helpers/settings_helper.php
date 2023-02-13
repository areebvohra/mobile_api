<?php


use Plivo\RestClient;
use \Firebase\JWT\JWT;

function generateRandomNumber($length = 5)
{
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomNumber = '';
    for ($i = 0; $i < $length; $i++) {
        $randomNumber .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomNumber;
}
function base64_url_encode($input)
{
    return strtr(base64_encode($input), '+/=', '._-');
}

function base64_url_decode($input)
{
    return base64_decode(strtr($input, '._-', '+/='));
}
function in_array_r($needle, $haystack, $strict = false)
{
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

function generateToken($data)
{
    $output = JWT::encode($data, TOKEN_SECRET_KEY);
    return $output;
}

function tokenAuthentication()
{
    $obj = &get_instance();
    $auth_token = $obj->input->get_request_header('Authorization', TRUE);
    if ($auth_token && $auth_token != 'undefined') {
        try {
            $secret_data = JWT::decode($auth_token, TOKEN_SECRET_KEY, array('HS256'));
        } catch (Exception $e) {
            $obj->response(array('status' => 'failed', 'message' => $e->getMessage()));
        }
        if (empty($secret_data)) {
            $obj->response(array('status' => 'failed', 'message' => 'Invalid user.'));
        } else {
            return $secret_data;
        }
    } else {
        $obj->response(array('status' => 'failed', 'message' => 'Invalid user.'));
    }
}
function tokenEmptyAuth()
{
    $obj = &get_instance();
    $auth_token = $obj->input->get_request_header('Authorization', TRUE);
    if ($auth_token && $auth_token != 'undefined') {
        try {
            $secret_data = JWT::decode($auth_token, TOKEN_SECRET_KEY, array('HS256'));
        } catch (Exception $e) {
            //echo 'Message: ' . $e->getMessage();
            return '';
        }
        if (empty($secret_data)) {
            return '';
        } else {
            return $secret_data;
        }
    } else {
        return '';
    }
}

function validation_errors_to_array($validation_rules)
{
    $errors_array = array(); //array is initialized

    foreach ($validation_rules as $row) {
        $field = $row['field'];          //getting field name

        $error = form_error($field);    //getting error for field name
        if ($error)
            $errors_array[$field] = $error;
    }
    return $errors_array;
}

function tokenDecode($data)
{
    $CI = &get_instance();
    if ($data) {
        try {
            $secret_data = JWT::decode($data, ENCRYPTION_KEY, array('HS256'));
        } catch (Exception $e) {
            $CI->response(array('status' => 'failed', 'message' => 'Invalid user.'));
        }
        if (empty($secret_data)) {
            $CI->response(array('status' => 'failed', 'message' => 'Invalid user.'));
        } else {
            return $secret_data;
        }
    } else {
        $CI->response(array('status' => 'failed', 'message' => 'Invalid user.'));
    }
}

function tokenEncode($data)
{
    $output = JWT::encode($data, ENCRYPTION_KEY);
    return $output;
}
