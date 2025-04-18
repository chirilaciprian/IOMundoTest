<?php
class FormService
{
    public function create($name, $email, $consent, $image)
    {        
        if (empty($email) || empty($name)) {
            return ['status' => 400, 'message' => 'Email and Name are required'];
        }

        if ($image && $image['tmp_name']) {       
            if (!$consent) {
                return ['status' => 400, 'message' => 'Consent must be true if there is an image'];
            }
            
            $imagePath = $this->handleImageUpload($image);
            if (!$imagePath) {
                return ['status' => 400, 'message' => 'Image upload failed'];
            }
        } else {         
            if ($consent) {
                return ['status' => 400, 'message' => 'Consent should not be true without an image'];
            }
            $imagePath = null;
        }

        $db = new Database();
        $conn = $db->connect();

        $sql = "INSERT INTO form_submissions (email, name, consent, image_path, created_at)
                VALUES (:email, :name, :consent, :image_path, NOW())";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':consent', $consent, PDO::PARAM_BOOL);
        $stmt->bindParam(':image_path', $imagePath);

        if ($stmt->execute()) {
            return ['status' => 200, 'message' => 'Form submitted successfully'];
        } else {
            return ['status' => 500, 'message' => 'Error inserting data into database'];
        }
    }
    
    private function handleImageUpload($image)
    {
        $uploadsDir = $_SERVER['DOCUMENT_ROOT'] . '/IOMundoApi/api/uploads/';
        if (!is_dir($uploadsDir)) {
            mkdir($uploadsDir, 0777, true);
        }
        if (!is_writable($uploadsDir)) {
            return null;
        }
        
        if ($image['error'] !== UPLOAD_ERR_OK) {
            return null;
        }
        
        $originalFileName = $image['name'];        
        $imagePath = $uploadsDir . $originalFileName;
        if (!$this->resizeImage($image['tmp_name'], $imagePath)) {
            return null;
        }
        
        return '/IOMundoApi/api/uploads/' . $originalFileName;
    }
    
    private function resizeImage($imageTmpName, $targetPath)
    {
        list($width, $height) = getimagesize($imageTmpName);
        if ($width > 500 || $height > 500) {
            $newWidth = $newHeight = 500;
            
            if ($width > $height) {
                $newHeight = ($height / $width) * $newWidth;
            } else {
                $newWidth = ($width / $height) * $newHeight;
            }            
            $image = imagecreatefromstring(file_get_contents($imageTmpName));
            $resizedImage = imagescale($image, $newWidth, $newHeight);

            return imagejpeg($resizedImage, $targetPath);
        } else {            
            return move_uploaded_file($imageTmpName, $targetPath);
        }
    }
    
    public function getAll()
    {
        $db = new Database();
        $conn = $db->connect();
        $sql = "SELECT * FROM form_submissions";
        $stmt = $conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
