<?php

declare(strict_types=1);

namespace App\Router;

use Nette\Application\Routers\RouteList;


final class RouterFactory
{
	public static function createRouter(): RouteList
	{
		$router = new RouteList;

		/**
		 * Admin
		 */
		$router->addRoute('admin/<presenter>/<action>[/<id \d+>]', [
			'presenter' => 'Homepage',
			'action' => 'default',
			'module' => 'Admin',
		]);

		/**
		 * Front
		 */
		$router->addRoute('/<presenter>/<action>[/<id \d+>]', [
			'presenter' => 'Homepage',
			'action' => 'default',
			'module' => 'Front',
		]);

		$router->addRoute('/<presenter>/<action>/tag/<id \d+>', [
			'presenter' => 'Product',
			'action' => 'tag',
			'module' => 'Front',
		]);

		$router->addRoute('/<presenter>/<action>/category/<id \d+>', [
			'presenter' => 'Product',
			'action' => 'category',
			'module' => 'Front',
		]);

		return $router;
	}
}
