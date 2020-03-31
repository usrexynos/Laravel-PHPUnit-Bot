<?php

$dorks = [
    // Type your dork here
    // ex
    'intext:"yourdork"',
    'intext:"yourdork3"',
    'intext:"yourdork22"',
    'intext:"yourdork66"',
    'intext:"yourdork2"'
];

foreach($dorks as $dork) {
    system("php phpunit-v2.php '$dork'");
}