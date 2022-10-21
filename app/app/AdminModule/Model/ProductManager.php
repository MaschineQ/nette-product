<?php

declare(strict_types=1);

namespace App\AdminModule\Model;

use Exception;
use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Utils\ArrayHash;

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


	public function getProduct(int $id): ?ActiveRow
	{
		return $this->database->table('product')->get($id);
	}


	public function addProduct(ArrayHash $values): void
	{
		$this->database->table('product')->insert($values);
	}


	/**
	 * @param int $id
	 * @param ArrayHash $values
	 * @throws Exception
	 */
	public function updateProduct(int $id, ArrayHash $values): void
	{
		$product = $this->database->table('product')->get($id);
		if ($product) {
			$product->update($values);
		} else {
			throw new Exception('Product not found');
		}
	}


	public function deleteProduct(int $id): void
	{
		$product = $this->database->table('product')->get($id);
		if ($product) {
			$product->delete();
		} else {
			throw new Exception('Product not found');
		}
	}
}
