<?php

require_once 'vendor/autoload.php';

use Utopia\Storage\Storage;
use Utopia\Storage\Device\Local;
use Utopia\Storage\Device\S3;
use Utopia\Storage\Device\DOSpaces;

// Configuration
$SPACES_BUCKET_NAME = getenv('SPACES_BUCKET_NAME');
$SPACES_REGION = getenv('SPACES_REGION');
$SPACES_ACCESS_KEY = getenv('SPACES_ACCESS_KEY');
$SPACES_SECRET_KEY = getenv('SPACES_SECRET_KEY');
$SPACES_ENDPOINT = getenv('SPACES_ENDPOINT');
$AWS_ACL_FLAG = 'ACL_PUBLIC'


// Instantiating local storage
// Storage::setDevice('files', new Local('path'));

// Or you can use AWS S3 storage
// Storage::setDevice('files', new S3('path', AWS_ACCESS_KEY, AWS_SECRET_KEY,AWS_BUCKET_NAME, AWS_REGION, AWS_ACL_FLAG));

// Or you can use DigitalOcean Spaces storage
Storage::setDevice('files', new DOSpaces('path', $SPACES_ACCESS_KEY, $SPACES_SECRET_KEY, $SPACES_BUCKET_NAME, $SPACES_REGION, $AWS_ACL_FLAG));

$device = Storage::getDevice('files');

//upload
//$device->upload('file.png','path');

?>
