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

        $database =
            ('sqlite' === $pdo->getAttribute(PDO::ATTR_DRIVER_NAME))
                ? null
                : $pdo->query('SELECT database()')->fetchColumn();

        $this->assertInternalType(
            (
                ('sqlite' === $pdo->getAttribute(PDO::ATTR_DRIVER_NAME))
                    ? 'null'
                    : 'string'
            ),
            $database
        );

        $configOptions = Integrator::ObtainConfig($instance);

        $this->assertSame($pdo, $configOptions['connection']);
        $this->assertSame($database, $configOptions['name']);
    }
}
