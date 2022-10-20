<?php

declare(strict_types=1);

namespace App\AdminModule\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;

class ProductManager
{
	public function __construct(
		private Explorer $database,
	) {

	}


	/**
	 * @return ActiveRow[]
	 */
	public function getProducts(): array
	{
		return $this->database->table('product')->fetchAll();
	}
}
