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

namespace Circle\DoctrineRestDriver\Tests\Exceptions;

use Circle\DoctrineRestDriver\Exceptions\Exceptions;
use Circle\DoctrineRestDriver\Exceptions\InvalidAuthStrategyException;
use Circle\DoctrineRestDriver\Exceptions\InvalidFormatException;
use Circle\DoctrineRestDriver\Exceptions\InvalidSqlOperationException;
use Circle\DoctrineRestDriver\Exceptions\MethodNotImplementedException;
use Circle\DoctrineRestDriver\Exceptions\RequestFailedException;
use Circle\DoctrineRestDriver\Exceptions\UnsupportedFetchModeException;
use Circle\DoctrineRestDriver\Types\Request;
use Circle\DoctrineRestDriver\Validation\Exceptions\InvalidTypeException;
use Circle\DoctrineRestDriver\Validation\Exceptions\NotNilException;

/**
 * Tests the exceptions trait
 *
 * @author    Tobias Hauck <tobias@circle.ai>
 * @copyright 2015 TeeAge-Beatz UG
 *
 * @coversDefaultClass Circle\DoctrineRestDriver\Exceptions\Exceptions
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
class ExceptionsTest extends \PHPUnit\Framework\TestCase {

    /**
     * @test
     * @group  unit
     * @covers ::invalidTypeException
     * @expectedException \Circle\DoctrineRestDriver\Validation\Exceptions\InvalidTypeException
     */
    public function invalidTypeExceptionTest() {
        $this->expectException(InvalidTypeException::class);
        Exceptions::invalidTypeException('expected', 'key', 'value');
    }

    /**
     * @test
     * @group  unit
     * @covers ::notNilException
     * @expectedException \Circle\DoctrineRestDriver\Validation\Exceptions\NotNilException
     */
    public function notNilExceptionTest() {
        $this->expectException(NotNilException::class);
        Exceptions::notNilException('test');
    }

    /**
     * @test
     * @group  unit
     * @covers ::unsupportedFetchModeException
     * @covers Circle\DoctrineRestDriver\Exceptions\UnsupportedFetchModeException::__construct
     * @expectedException \Circle\DoctrineRestDriver\Exceptions\UnsupportedFetchModeException
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    public function unsupportedFetchModeExceptionTest() {
        $this->expectException(UnsupportedFetchModeException::class);
        Exceptions::unsupportedFetchModeException(\PDO::FETCH_CLASS);
    }

    /**
     * @test
     * @group  unit
     * @covers ::methodNotImplementedException
     * @covers Circle\DoctrineRestDriver\Exceptions\MethodNotImplementedException::__construct
     * @expectedException \Circle\DoctrineRestDriver\Exceptions\MethodNotImplementedException
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    public function methodNotImplementedExceptionTest() {
        $this->expectException(MethodNotImplementedException::class);
        Exceptions::methodNotImplementedException('class', 'method');
    }

    /**
     * @test
     * @group  unit
     * @covers ::requestFailedException
     * @covers Circle\DoctrineRestDriver\Exceptions\RequestFailedException::__construct
     * @expectedException \Circle\DoctrineRestDriver\Exceptions\RequestFailedException
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    public function requestFailedExceptionTest() {
        $this->expectException(RequestFailedException::class);
        Exceptions::requestFailedException(new Request(['method' => 'get', 'url' => 'url']), 1, 'errorMessage');
    }

    /**
     * @test
     * @group  unit
     * @covers ::invalidAuthStrategyException
     * @covers Circle\DoctrineRestDriver\Exceptions\InvalidAuthStrategyException::__construct
     * @expectedException \Circle\DoctrineRestDriver\Exceptions\InvalidAuthStrategyException
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    public function invalidAuthStrategyExceptionTest() {
        $this->expectException(InvalidAuthStrategyException::class);
        Exceptions::invalidAuthStrategyException('class');
    }

    /**
     * @test
     * @group  unit
     * @covers ::invalidSqlOperationException
     * @covers Circle\DoctrineRestDriver\Exceptions\InvalidSqlOperationException::__construct
     * @expectedException \Circle\DoctrineRestDriver\Exceptions\InvalidSqlOperationException
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    public function invalidSqlOperationExceptionTest() {
        $this->expectException(InvalidSqlOperationException::class);
        Exceptions::invalidSqlOperationException('operation');
    }

    /**
     * @test
     * @group  unit
     * @covers ::invalidFormatException
     * @covers Circle\DoctrineRestDriver\Exceptions\InvalidFormatException::__construct
     * @expectedException \Circle\DoctrineRestDriver\Exceptions\InvalidFormatException
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    public function invalidFormatExceptionTest() {
        $this->expectException(InvalidFormatException::class);
        Exceptions::invalidFormatException('class');
    }
}
