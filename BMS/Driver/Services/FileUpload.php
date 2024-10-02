<?php
class FileUpload {

    public function uploadFile($file, $targetDir, $allowedTypes = ['jpg', 'png', 'jpeg', 'pdf']) {

        if (!isset($file) || $file['error'] == UPLOAD_ERR_NO_FILE) {
            return [
                'status' => 'error',
                'message' => 'No file selected.'
            ];
        }

        $randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 16); // Generate a random string
        $currentDateTime = date("YmdHis"); // Get current date and time
        $imageFileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)); // Get file extension
        $targetFile = $targetDir . $currentDateTime . "_" . $randomString . "." . $imageFileType; // Construct target file path

        $fileName = $currentDateTime . "_" . $randomString . "." . $imageFileType;

        // Check if the file type is allowed
        if (!in_array($imageFileType, $allowedTypes)) {
            return [
                'status' => 'error',
                'message' => 'Sorry, only ' . implode(', ', $allowedTypes) . ' files are allowed.'
            ];
        }

        // Move uploaded file to target directory
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            return [
                'status' => 'success',
                'fileName' => $fileName
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Sorry, there was an error uploading your file.'
            ];
        }
    }
}