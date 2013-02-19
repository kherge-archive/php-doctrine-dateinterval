<?php

$loader = require __DIR__ . '/../vendors/autoload.php';
$loader->add('Doctrine\\Tests', __DIR__ . '/../vendors/doctrine/dbal/tests');
$loader->add('Doctrine\\Tests', __DIR__ . '/../vendors/doctrine/orm/tests');

use Doctrine\DBAL\Types\Type;
use Herrera\Doctrine\DBAL\Types\DateIntervalType;

Type::addType(
    DateIntervalType::DATEINTERVAL,
    'Herrera\\Doctrine\\DBAL\\Types\\DateIntervalType'
);