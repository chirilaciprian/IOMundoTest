<?php

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/../services/FormService.php';

class FormController
{
    public function create()
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $consent = isset($_POST['consent']) ? $_POST['consent'] : null;
        $image = $_FILES['image'] ?? null;

        if (empty($email) || empty($name)) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['message' => 'Email and Name are required']);
            return;
        }
        if (!$consent) {
            http_response_code(400);
            echo json_encode(['message' => 'Consent must be accepted.']);
            return;
        }
        if ($image && $image['tmp_name']) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

            if (!in_array($extension, $allowedExtensions)) {
                http_response_code(400);
                echo json_encode(['message' => 'Invalid image extension. Allowed: jpg, jpeg, png, gif.']);
                return;
            }
        }

        $formService = new FormService();
        $result = $formService->create($name, $email, $consent, $image);

        header('Content-Type: application/json');
        http_response_code($result['status']);
        echo json_encode(['message' => $result['message']]);
    }

    public function getAll()
    {
        $formService = new FormService();
        $records = $formService->getAll();

        header('Content-Type: application/json');
        echo json_encode($records);
    }
}
