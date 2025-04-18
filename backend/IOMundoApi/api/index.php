<?php

// CORS
header("Access-Control-Allow-Origin: http://localhost:5173");  // client domain
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

require_once 'controllers/FormController.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$basePath = '/IOMundoApi/api';
if (strpos($requestUri, $basePath) === 0) {
    $requestUri = substr($requestUri, strlen($basePath));
}
$requestUri = rtrim($requestUri, '/');

if ($requestMethod === 'POST' && $requestUri === '/submit') {
    $controller = new FormController();
    $controller->create();
} elseif ($requestMethod === 'GET' && $requestUri === '/records') {
    $controller = new FormController();
    $controller->getAll();
} else {
    http_response_code(404);
    echo json_encode(["message" => "Route not found."]);
}
