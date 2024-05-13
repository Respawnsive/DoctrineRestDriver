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

namespace Circle\DoctrineRestDriver;

use Circle\DoctrineRestDriver\Annotations\RoutingTable;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\DBAL\Driver\ServerInfoAwareConnection; // TODO voir
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Connection as ConnectionInterface;
use Doctrine\DBAL\Statement as StatementInterface;
use Doctrine\DBAL\Result as ResultInterface;

/**
 * Doctrine connection for the rest driver
 *
 * @author    Tobias Hauck <tobias@circle.ai>
 * @copyright 2015 TeeAge-Beatz UG
 * @method object getNativeConnection()
 */
class Connection extends ConnectionInterface
{

    /**
     * @var Statement
     */
    private $statement;

    /**
     * @var array
     */
    private $routings;

    /**
     * Connection constructor
     *
     * @param array        $params
     * @param Driver       $driver
     * @param RoutingTable $routings
     */
    public function __construct(array $params, Driver $driver, RoutingTable $routings, Configuration $config = null, EventManager $eventManager = null) {
        $this->routings = $routings;
        $this->driver = $driver ;
        $this->params = $params ;
//        parent::__construct($params, $driver, $config, $eventManager);
    }

    /**
     * prepares the statement execution
     *
     * @param string $statement
     * @return \Doctrine\DBAL\Driver\Statement
     * @throws Exception
     */
    public function prepare(string $sql): StatementInterface
    {
        $this->driver->connect($this->params);
        $this->statement = new Statement($sql, $this->params, $this->routings);
        $this->statement->setFetchMode(\PDO::FETCH_ASSOC); // TODO voir

            // $this->defaultFetchMode);

        return $this->statement;
    }

    /**
     * returns the last inserted id
     *
     * @param  string|null $seqName
     * @return int
     *
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     */
    public function lastInsertId($seqName = null) {
        return $this->statement->getId();
    }

    /**
     * Executes a query, returns a statement
     *
     * @param string $sql
     * @return Statement
     */
    public function query(string $sql): ResultInterface
    {
        $statement = $this->prepare(func_get_args()[0]);
        $statement->execute();

        return $statement;
    }

    public function quote($value, $type = ParameterType::STRING)
    {
        // TODO: Implement quote() method.
    }

    public function exec(string $sql): int
    {
        // TODO: Implement exec() method.
        return true ;
    }

    public function beginTransaction()
    {
        // TODO: Implement beginTransaction() method.
        return true ;
    }

    public function commit()
    {
        // TODO: Implement commit() method.
        return true ;
    }

    public function rollBack()
    {
        // TODO: Implement rollBack() method.
        return true ;
    }

//    public function __call(string $name, array $arguments)
//    {
//        // TODO: Implement @method object getNativeConnection()
//        return true ;
//    }

    public function getServerVersion()
    {
        // TODO: Implement getServerVersion() method.
        return "1.0" ;
    }
}
