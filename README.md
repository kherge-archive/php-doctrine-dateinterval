Doctrine DateInterval Type
==========================

[![Build Status](https://travis-ci.org/herrera-io/php-doctrine-dateinterval.png?branch=master)](https://travis-ci.org/herrera-io/php-doctrine-dateinterval)

Supports DateInterval in Doctrine DBAL and ORM.

Summary
-------

The `DateInterval` library

- adds a `dateinterval` type to DBAL
- adds a `DATE_INTERVAL` DQL function to ORM

This is made possible by the [`DateInterval`](https://github.com/herrera-io/php-date-interval) library.

Installation
------------

Add it to your list of Composer dependencies:

```sh
$ composer require herrera-io/doctrine-dateinterval=1.*
```

Register it with Doctrine DBAL:

```php
<?php

use Doctrine\DBAL\Types\Type;
use Herrera\Doctrine\DBAL\Types\DateIntervalType;

Type::addType(
    DateIntervalType::DATEINTERVAL,
    'Herrera\\Doctrine\\DBAL\\Types\\DateIntervalType'
);
```

Register it with Doctrine ORM:

```php
<?php

$entityManager->getConfiguration()->addCustomDatetimeFunction(
    'Herrera\\Doctrine\\ORM\\Query\\AST\\Functions\\DateIntervalFunction'
);
```

Usage
-----

```php
<?php

/**
 * @Entity()
 * @Table(name="Jobs")
 */
class Job
{
    /**
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @Id()
     */
    private $id;

    /**
     * @Column(type="dateinterval")
     */
    private $interval;

    /**
     * @return DateInterval
     */
    public function getInterval()
    {
        return $this->interval;
    }

    /**
     * @param DateInterval $interval
     */
    public function setInterval(DateInterval $interval)
    {
        $this->interval = $interval;
    }
}

$annualJob = new Job();
$annualJob->setInterval(new DateInterval('P1Y'));

$monthlyJob = new Job();
$monthlyJob->setInterval(new DateInterval('P1M'));

$dailyJob = new Job();
$dailyJob->setInterval(new DateInterval('P1D'));

$entityManager->persist($annualJob);
$entityManager->persist($monthlyJob);
$entityManager->persist($dailyJob);
$entityManager->flush();
$entityManager->clear();

$jobs = $entityManager->createQuery(
    "SELECT j FROM Jobs j WHERE j.interval < DATE_INTERVAL('P1Y') ORDER BY j.interval ASC"
)->getResult();

echo $jobs[0]->getInterval()->toSpec(); // "P1D"
echo $jobs[1]->getInterval()->toSpec(); // "P1M"
```

> **NOTICE** The date interval instances returned are of `Herrera\DateInterval\DateInterval`.