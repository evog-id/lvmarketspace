<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// Configuration
$spaceName = getenv('SPACES_BUCKET_NAME');
$region = getenv('SPACES_REGION');
$key = getenv('SPACES_ACCESS_KEY');
$secret =getenv('SPACES_SECRET_KEY');

// Initialize S3 client
$s3Client = new S3Client([
    'version' => 'latest',
    'region'  => $region,
    'endpoint' => "https://{$region}.digitaloceanspaces.com",
    'credentials' => [
        'key'    => $key,
        'secret' => $secret,
    ],
]);

//Array
//$FilesArray = array(
//    [name] => array( /* these arrays are the size you expect */ ),
//    [tmp_name] => array( /* these arrays are the size you expect */ ),
//);

// File to upload
$filePath = 'oc-content/uploads/user-images/default-user-image.png';
$dir = 'oc-content/uploads/user-images'
//$files = scandir('oc-content/uploads/user-images');
//$keyName = basename($filePath);
$fileName = basename($filePath);

// Upload file
function uploadFile($s3Client, $spaceName, $filePath, $fileName) {
try {
    $result = $s3Client->putObject([
        'Bucket' => $spaceName,
        'Key'    => $fileName,
        'SourceFile' => $filePath,
        'ACL'    => 'public-read', // Optional: Set file permissions
    ]);

    echo "File uploaded successfully. URL: " . $result['ObjectURL'] . "\n";
} catch (AwsException $e) {
    echo "Error uploading file: " . $e->getMessage() . "\n";
  }
}

uploadFile($s3Client, $spaceName, $filePath, $fileName);

function dirToArray($dir) {
    $contents = array();
    foreach (scandir($dir) as $node) {
        if ($node == '.' || $node == '..') continue;
        if (is_dir($dir . '/' . $node)) {
            $contents[$node] = dirToArray($dir . '/' . $node);
        } else {
            $contents[] = $node;
        }
    }
    return $contents;
}

$files = dirToArray($dir);

// Handle multiple file uploads
if (!empty($files)) {
    foreach ($files['tmp_name'] as $index => $tmpName) {
        $filePath = $tmpName;
        $fileName = $files['name'][$index];
        uploadFile($s3Client, $spaceName, $filePath, $fileName);
    }
} else {
    echo "No files uploaded.";
}
?>
