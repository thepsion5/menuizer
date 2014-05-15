<?php
require_once('../vendor/autoload.php');

$menuizer = Thepsion5\Menuizer\MenuizerService::create();

$menuizer->define('primary', array(
    '/|label:Home',
    '/news|label:News|class:highlight',
    '/about|label:About Us',
    '/staff|label:Our Team',
    '/projects|label:Major Projects'
));

$menuizer->define('secondary', array(
    '/|label:Home',
    '/contact-us|label:Get in Touch',
    '/terms-of-service|label:Terms of Service',
    '/disclaimer|label:Disclaimer'
));