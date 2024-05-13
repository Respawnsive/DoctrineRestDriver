<?php
/**
 * This file is part of DoctrineRestDriver.
 *
 * DoctrineRestDriver is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * DoctrineRestDriver is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with DoctrineRestDriver.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Circle\DoctrineRestDriver\Tests;

use Doctrine\DBAL\Connection as AbstractConnection;
use Circle\DoctrineRestDriver\Connection;
use Circle\DoctrineRestDriver\Driver;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Schema\MySqlSchemaManager ;

use PHPUnit\Framework\TestCase;

/**
 * Tests the driver
 *
 * @author    Tobias Hauck <tobias@circle.ai>
 * @copyright 2015 TeeAge-Beatz UG
 *
 * @coversDefaultClass Circle\DoctrineRestDriver\Driver
 */
class DriverTest extends TestCase {

    /**
     * @var Driver
     */
    private $driver;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        $this->driver = new Driver();
    }

    /**
     * @test
     * @group  unit
     * @covers ::getDatabasePlatform
     */
    public function getDatabasePlatform() {
        $this->assertInstanceOf('Doctrine\DBAL\Platforms\MySqlPlatform', $this->driver->getDatabasePlatform());
    }

    /**
     * @test
     * @group  unit
     * @covers ::getSchemaManager
     */
    public function getSchemaManager() {
//        $connection = $this->driver->connect([]) ;
        // Circle\DoctrineRestDriver\Connection
        // TODO : david voir
        $connection = $this->getMockBuilder(Connection::class)->disableOriginalConstructor()->getMock() ;
        $platform = $this->getMockBuilder(AbstractPlatform::class)->disableOriginalConstructor()->getMock();
        $actual =  $this->driver->getSchemaManager($connection,$platform) ;
        $this->assertInstanceOf(MySqlSchemaManager::class,$actual);
    }

    /**
     * @test
     * @group  unit
     * @covers ::getName
     */
    public function getNameTest() {
        $this->assertSame('circle_rest', $this->driver->getName());
    }

    /**
     * @test
     * @group  unit
     * @covers ::getDatabase
     */
    public function getDatabase() {
        $connection = $this->getMockBuilder('Circle\DoctrineRestDriver\Connection')->disableOriginalConstructor()->getMock();
        $this->assertSame('rest_database', $this->driver->getDatabase($connection));
    }

    /**
     * @test
     * @group  unit
     * @covers ::connect
     * @covers ::<private>
     */
    public function connect() {
        $params = [
            'driverClass'   => 'Circle\DoctrineRestDriver\Driver',
            'driverOptions' => [
                'security_strategy' => 'none'
            ],
            'user'     => 'user',
            'password' => 'password',
            'host'     => 'localhost'
        ];
        $connection = $this->driver->connect($params, null, null, $params['driverOptions']);
        $this->assertInstanceOf('Circle\DoctrineRestDriver\Connection', $connection);
    }
}
