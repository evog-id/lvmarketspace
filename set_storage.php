<?php

require_once 'vendor/autoload.php';

use Utopia\Storage\Storage;
use Utopia\Storage\Device\Local;
use Utopia\Storage\Device\S3;
use Utopia\Storage\Device\DOSpaces;

// Configuration
$spaceName = getenv('SPACES_BUCKET_NAME');
$region = getenv('SPACES_REGION');
$key = getenv('SPACES_ACCESS_KEY');
$secret = getenv('SPACES_SECRET_KEY');
$spEndpoint = getenv('SPACES_ENDPOINT');
$acl = 'ACL_PUBLIC'

// Instantiating local storage
// Storage::setDevice('files', new Local('path'));

// Or you can use AWS S3 storage
// Storage::setDevice('files', new S3('path', AWS_ACCESS_KEY, AWS_SECRET_KEY,AWS_BUCKET_NAME, AWS_REGION, AWS_ACL_FLAG));

// Or you can use DigitalOcean Spaces storage
Storage::setDevice('files', new DOSpaces('oc-content/uploads', $key, $secret, $spaceName, $region, $acl));

$device = Storage::getDevice('files');

//upload
//$device->upload('file.png','path');

?>
