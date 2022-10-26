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


	/**
	 * @return array<ActiveRow>
	 */
	public function getProductsByTag(int $id): array
	{
		return $this->database->table('product_tag')->where('tag_id', $id)->fetchAll();
	}


	public function getProductTag(int $id): ?ActiveRow
	{
		return $this->database->table('tag')->get($id);
	}

    /**
     * @return array<ActiveRow>
     */
	public function getProductsByCategory(int $id): array
	{
		return $this->database->table('product')->where('category', $id)->fetchAll();
	}


	public function getProductCategory(int $id): ?ActiveRow
	{
		return $this->database->table('category')->get($id);
	}
}
