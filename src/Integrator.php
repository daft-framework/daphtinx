<?php
/**
* @author SignpostMarv
*/
declare(strict_types=1);

namespace SignpostMarv\DaftFramework\Phinx;

use PDO;
use SignpostMarv\DaftFramework\Framework;

class Integrator
{
    public static function ObtainConfig(Framework $framework) : array
    {
        $pdo = $framework->ObtainDatabaseConnection()->getPdo();

        return [
            'name' => (
                ('sqlite' === $pdo->getAttribute(PDO::ATTR_DRIVER_NAME))
                    ? null
                    : $pdo->query('SELECT database()')->fetchColumn()
            ),
            'connection' => $pdo,
        ];
    }
}
