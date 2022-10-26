<?php

declare(strict_types=1);

namespace App\FrontModule\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;

class TagManager
{
	public function __construct(
		private Explorer $database,
	) {
	}


	/**
	 * @return array<ActiveRow>
	 */
	public function getTags(): array
	{
		return $this->database->table('tag')->fetchAll();
	}


	public function getTag(int $id): ?ActiveRow
	{
		return $this->database->table('tag')->get($id);
	}
}
