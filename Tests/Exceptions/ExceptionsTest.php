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
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;

/**
 * Tests the exceptions trait
 *
 * @author    Tobias Hauck <tobias@circle.ai>
 * @copyright 2015 TeeAge-Beatz UG
 *
 *
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
#[CoversClass(Exceptions::class)]
#[CoversMethod(Exceptions::class, 'invalidTypeException')]
#[CoversMethod(Exceptions::class, 'notNilException')]
#[CoversMethod(Exceptions::class, 'unsupportedFetchModeException')]
#[CoversMethod(Exceptions::class, 'methodNotImplementedException')]
#[CoversMethod(Exceptions::class, 'requestFailedException')]
#[CoversMethod(Exceptions::class, 'invalidAuthStrategyException')]
#[CoversMethod(Exceptions::class, 'invalidSqlOperationException')]
#[CoversMethod(Exceptions::class, 'invalidFormatException')]
class ExceptionsTest extends \PHPUnit\Framework\TestCase {

    #[Test]
    #[Group('unit')]
    public function invalidTypeExceptionTest() {
        $this->expectException(InvalidTypeException::class);
        Exceptions::invalidTypeException('expected', 'key', 'value');
    }

    #[Test]
    #[Group('unit')]
    public function notNilExceptionTest() {
        $this->expectException(NotNilException::class);
        Exceptions::notNilException('test');
    }

    /**
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    #[Test]
    #[Group('unit')]
    public function unsupportedFetchModeExceptionTest() {
        $this->expectException(UnsupportedFetchModeException::class);
        Exceptions::unsupportedFetchModeException(\PDO::FETCH_CLASS);
    }

    /**
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    #[Test]
    #[Group('unit')]
    public function methodNotImplementedExceptionTest() {
        $this->expectException(MethodNotImplementedException::class);
        Exceptions::methodNotImplementedException('class', 'method');
    }

    /**
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    #[Test]
    #[Group('unit')]
    public function requestFailedExceptionTest() {
        $this->expectException(RequestFailedException::class);
        Exceptions::requestFailedException(new Request(['method' => 'get', 'url' => 'url']), 1, 'errorMessage');
    }

    /**
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    #[Test]
    #[Group('unit')]
    public function invalidAuthStrategyExceptionTest() {
        $this->expectException(InvalidAuthStrategyException::class);
        Exceptions::invalidAuthStrategyException('class');
    }

    /**
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    #[Test]
    #[Group('unit')]
    public function invalidSqlOperationExceptionTest() {
        $this->expectException(InvalidSqlOperationException::class);
        Exceptions::invalidSqlOperationException('operation');
    }

    /**
     *
     * @SuppressWarnings("PHPMD.StaticAccess")
     */
    #[Test]
    #[Group('unit')]
    public function invalidFormatExceptionTest() {
        $this->expectException(InvalidFormatException::class);
        Exceptions::invalidFormatException('class');
    }
}
