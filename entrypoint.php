<?php
declare(strict_types=1);

use Gumeniukcom\Logger;
use Gumeniukcom\SM\Transformer\PostsTransform;
use Gumeniukcom\SM\Transformer\PostTransform;
use Gumeniukcom\SM\Transformer\TokenTransform;

require_once 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);

$dotenv->safeLoad();

$dotenv->required(['API_ADDR', 'CLIENT_ID', 'USER_NAME', 'USER_EMAIL']);

$configApiAddr = $_ENV['API_ADDR'];
$configClientId = $_ENV['CLIENT_ID'];
$configUserName = $_ENV['USER_NAME'];
$configUserEmail = $_ENV['USER_EMAIL'];

$logger = new Logger('testing');

$netClient = \Gumeniukcom\SM\NetClientGuzzle::withConfig($configApiAddr, $logger);
//$netClient = new \Gumeniukcom\SM\NetClient($configApiAddr, $logger);

$postTransformer = new PostTransform($logger);
$postsTransformer = new PostsTransform($logger, $postTransformer);
$tokenTransformer = new TokenTransform($logger);

$smClient = new \Gumeniukcom\SM\Client($netClient, $logger, $postsTransformer, $tokenTransformer);

$service = new \Gumeniukcom\Service($logger, $smClient);


try {
    $service->run($configClientId, $configUserEmail, $configUserName);
} catch (Exception $exception) {
    echo 'Some exception: ' . $exception->getMessage();
}
