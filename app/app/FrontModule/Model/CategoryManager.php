<?php

declare(strict_types=1);

namespace App\FrontModule\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;

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


	public function getCategory(int $id): ?ActiveRow
	{
		return $this->database->table('category')->get($id);
	}
}
