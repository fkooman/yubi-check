<?php

$baseDir = dirname(__DIR__);

// find the autoloader (package installs, composer)
foreach (['src', 'vendor'] as $autoloadDir) {
    if (@file_exists(sprintf('%s/%s/autoload.php', $baseDir, $autoloadDir))) {
        require_once sprintf('%s/%s/autoload.php', $baseDir, $autoloadDir);
        break;
    }
}

use fkooman\YubiCheck\Request;
use fkooman\YubiCheck\Response;
use fkooman\YubiCheck\Service;
use fkooman\YubiTwee\CurlMultiHttpClient;
use fkooman\YubiTwee\Validator;

try {
    $srv = new Service(
        new Validator(new CurlMultiHttpClient())
    );
    $srv->run(
        new Request($_SERVER, $_GET, $_POST)
    )->send();
} catch (Exception $e) {
    $response = new Response(500, [], sprintf('ERROR: %s', $e->getMessage()));
    $response->send();
}
