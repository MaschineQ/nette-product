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


	/**
	 * @param mixed[] $tags
	 */
	public function addProduct(ArrayHash $values, array $tags): void
	{
		/** @var ActiveRow $product */
		$product = $this->database->table('product')->insert($values);

		assert(is_int($product->id));
		$this->insertTags($product->id, $tags);
	}


	/**
	 * @param mixed[] $tags
	 */
	public function updateProduct(int $id, ArrayHash $values, array $tags): void
	{
		$product = $this->database->table('product')->get($id);
		if ($product) {
			$product->update($values);
			$this->deleteTags($id);
			$this->insertTags($id, $tags);
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


	/**
	 * @param mixed[] $tags
	 */
	public function insertTags(int $productId, array $tags): void
	{
		foreach ($tags as $tag) {
			$this->database->table('product_tag')->insert([
				'product_id' => $productId,
				'tag_id' => $tag,
			]);
		}
	}


	public function deleteTags(int $productId): void
	{
		$this->database->table('product_tag')->where('product_id', $productId)->delete();
	}
}
