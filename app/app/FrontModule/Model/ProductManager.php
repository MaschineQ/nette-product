<?php

declare(strict_types=1);

namespace App\FrontModule\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;

class ProductManager
{
	public function __construct(
		private Explorer $database,
	) {
	}


	/**
	 * @return array<ActiveRow>
	 */
	public function getProducts(): array
	{
		return $this->database->table('product')->fetchAll();
	}


	/**
	 * @return array<ActiveRow>
	 */
	public function getLatestProducts(): array
	{
		return $this->database->table('product')->order('id DESC')->limit(3)->fetchAll();
	}


	public function getProduct(int $id): ?ActiveRow
	{
		return $this->database->table('product')->get($id);
	}
}
