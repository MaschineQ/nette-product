<?php

declare(strict_types=1);

namespace App\AdminModule\Model;

use Exception;
use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Utils\ArrayHash;

class CategoryManager
{
	public function __construct(
		private Explorer $database,
	) {
	}


	/**
	 * @return array<ActiveRow>
	 */
	public function getCategories(): array
	{
		return $this->database->table('category')->fetchAll();
	}


	/**
	 * @return array<ActiveRow>
	 */
	public function getCategoriesForSelect(): array
	{
		return $this->database->table('category')->fetchPairs('id', 'name');
	}


	public function getCategory(int $id): ?ActiveRow
	{
		return $this->database->table('category')->get($id);
	}


	public function addCategory(ArrayHash $values): void
	{
		$this->database->table('category')->insert($values);
	}


	/**
	 * @param int $id
	 * @param ArrayHash $values
	 * @throws Exception
	 */
	public function updateCategory(int $id, ArrayHash $values): void
	{
		$category = $this->database->table('category')->get($id);
		if ($category) {
			$category->update($values);
		} else {
			throw new Exception('Category not found');
		}
	}


	public function deleteCategory(int $id): void
	{
		$category = $this->database->table('category')->get($id);
		if ($category) {
			$category->delete();
		} else {
			throw new Exception('Category not found');
		}
	}
}
