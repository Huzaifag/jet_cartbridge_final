<?php
// Simple PHP upload test script
header('Content-Type: application/json');

$info = [
    'php_version' => PHP_VERSION,
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size' => ini_get('post_max_size'),
    'max_file_uploads' => ini_get('max_file_uploads'),
    'max_execution_time' => ini_get('max_execution_time'),
    'memory_limit' => ini_get('memory_limit'),
    'file_uploads' => ini_get('file_uploads') ? 'enabled' : 'disabled',
    'upload_tmp_dir' => ini_get('upload_tmp_dir') ?: 'default',
    'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'unknown',
    'request_method' => $_SERVER['REQUEST_METHOD'] ?? 'unknown',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $info['post_data'] = [
        'has_files' => !empty($_FILES),
        'files_count' => count($_FILES),
        'content_length' => $_SERVER['CONTENT_LENGTH'] ?? 0,
        'content_type' => $_SERVER['CONTENT_TYPE'] ?? 'unknown',
    ];
    
    if (!empty($_FILES)) {
        foreach ($_FILES as $key => $file) {
            if (is_array($file['name'])) {
                // Multiple files
                for ($i = 0; $i < count($file['name']); $i++) {
                    $info['files'][] = [
                        'name' => $file['name'][$i],
                        'size' => $file['size'][$i],
                        'type' => $file['type'][$i],
                        'error' => $file['error'][$i],
                        'tmp_name' => $file['tmp_name'][$i],
                    ];
                }
            } else {
                // Single file
                $info['files'][] = [
                    'name' => $file['name'],
                    'size' => $file['size'],
                    'type' => $file['type'],
                    'error' => $file['error'],
                    'tmp_name' => $file['tmp_name'],
                ];
            }
        }
    }
}

echo json_encode($info, JSON_PRETTY_PRINT);
?>