<?php

namespace Herrera\Doctrine\ORM\Query\AST\Functions\Tests;

use DateInterval;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Tools\Setup;
use PHPUnit_Framework_TestCase;

class DateIntervalFunctionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var EntityManager
     */
    private $em;

    public function testFunction()
    {
        $query = $this->em->createQuery(sprintf(
            "SELECT j FROM %s\\Job j WHERE j.interval < DATE_INTERVAL('PT1H')",
            __NAMESPACE__
        ));

        $this->assertEquals(
            'SELECT j0_.id AS id0, j0_.interval AS interval1 FROM Jobs j0_ WHERE j0_.interval < 3600',
            $query->getSQL()
        );
    }

    protected function setUp()
    {
        $this->em = EntityManager::create(
            array(
                'driver' => 'pdo_sqlite',
                'memory' => true
            ),
            Setup::createAnnotationMetadataConfiguration(array())
        );

        $this->em->getConfiguration()->addCustomDatetimeFunction(
            'DATE_INTERVAL',
            'Herrera\\Doctrine\\ORM\\Query\\AST\\Functions\\DateIntervalFunction'
        );
    }
}

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