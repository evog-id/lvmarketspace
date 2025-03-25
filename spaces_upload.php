<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

// Configuration
$spaceName = getenv('SPACES_BUCKET_NAME');
$region = getenv('SPACES_REGION');
$key = getenv('SPACES_ACCESS_KEY');
$secret = getenv('SPACES_SECRET_KEY');
$spEndpoint = getenv('SPACES_ENDPOINT');

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

// File to upload
$filePath = 'oc-content/uploads/user-images/default-user-image.png';
$directoryPath = 'oc-content/uploads';
$fileName = basename($filePath);
$keyName = $directoryPath . "/" .  $fileName;

// Upload one file
function uploadFile($s3Client, $spaceName, $filePath, $keyName) {
try {
    $result = $s3Client->putObject([
        'Bucket' => $spaceName,
        'Key'    => $keyName,
        'SourceFile' => $filePath,
        'ACL'    => 'public-read', // Optional: Set file permissions
    ]);

    echo "File uploaded successfully. URL: " . $result['ObjectURL'] . "\n";
} catch (AwsException $e) {
    echo "Error uploading file: " . $e->getMessage() . "\n";
  }
}
uploadFile($s3Client, $spaceName, $filePath, $keyName);

// Get array of all files in directory
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
//$files = dirToArray($dir);

// Handle multiple file uploads
function iterateFilesInDirectory($s3Client, $spaceName, $dir) {
$iterator = new RecursiveDirectoryIterator($dir);
$iterator = new RecursiveIteratorIterator($iterator, RecursiveIteratorIterator::SELF_FIRST);

foreach ($iterator as $file) {
    if ($file->isFile()) {
        $filePath = $file->getPathname();
        $fileName = basename($filePath);
        $keyName = $dir . "/" .  $fileName;
        uploadFile($s3Client, $spaceName, $filePath, $keyName);
   } else {
    echo "No files uploaded.";
    }
  }
}
iterateFilesInDirectory($s3Client, $spaceName, $directoryPath);
?>
