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

		/**
		* @var \PDOStatement
		*/
		$sth = $pdo->query(
			('sqlite' === $pdo->getAttribute(PDO::ATTR_DRIVER_NAME))
				? 'PRAGMA database_list;'
				: 'SELECT database()'
		);

		return [
			'name' => (
				('sqlite' === $pdo->getAttribute(PDO::ATTR_DRIVER_NAME))
					? $sth->fetchColumn(1)
					: $sth->fetchColumn()
			),
			'connection' => $pdo,
		];
	}
}
