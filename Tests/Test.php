<?php
/**
* @author SignpostMarv
*/
declare(strict_types=1);

namespace SignpostMarv\DaftFramework\Phinx\Tests;

use PDO;
use SignpostMarv\DaftFramework\Phinx\Integrator;
use SignpostMarv\DaftFramework\Tests\ImplementationTest as Base;

class Test extends Base
{
    /**
    * @param array<string, array<int, mixed>> $postConstructionCalls
    * @param mixed ...$implementationArgs
    *
    * @dataProvider DataProviderGoodSourcesWithDatabaseConnection
    */
    public function testIntegrator(
        string $implementation,
        array $postConstructionCalls,
        ...$implementationArgs
    ) : void {
        $instance = $this->ObtainFrameworkInstance($implementation, ...$implementationArgs);
        $this->ConfigureFrameworkInstance($instance, $postConstructionCalls);

        $pdo = $instance->ObtainDatabaseConnection()->getPdo();

        /**
        * @var \PDOStatement
        */
        $sth = $pdo->query(
            ('sqlite' === $pdo->getAttribute(PDO::ATTR_DRIVER_NAME))
                ? 'PRAGMA database_list;'
                : 'SELECT database()'
        );

        $database =
            ('sqlite' === $pdo->getAttribute(PDO::ATTR_DRIVER_NAME))
                ? $sth->fetchColumn(1)
                : $sth->fetchColumn();

        static::assertIsString(
            $database
        );

        $configOptions = Integrator::ObtainConfig($instance);

        static::assertSame($pdo, $configOptions['connection']);
        static::assertSame($database, $configOptions['name']);
    }
}
