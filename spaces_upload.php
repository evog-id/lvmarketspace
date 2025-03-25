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

// File to upload
$filePath = 'oc-content/uploads/user-images/2_0Egog_20250325.png';
$keyName = basename($filePath);

try {
    // Upload file
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
?>
