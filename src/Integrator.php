<?php
/**
* @author SignpostMarv
*/
declare(strict_types=1);

namespace SignpostMarv\DaftFramework\Phinx;

use SignpostMarv\DaftFramework\Framework;

class Integrator
{
    public static function ObtainConfig(Framework $framework) : array
    {
        $pdo = $framework->ObtainDatabaseConnection()->getPdo();

        return [
            'name' => $pdo->query('SELECT database()')->fetchColumn(),
            'connection' => $pdo,
        ];
    }
}
