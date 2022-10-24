<?php

declare(strict_types=1);

namespace App\AdminModule\Model;

use Exception;
use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Utils\ArrayHash;

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


	/**
	 * @return array<ActiveRow>
	 */
	public function getTagsForSelect(): array
	{
		return $this->database->table('tag')->fetchPairs('id', 'name');
	}


	public function getTag(int $id): ?ActiveRow
	{
		return $this->database->table('tag')->get($id);
	}


	public function addTag(ArrayHash $values): void
	{
		$this->database->table('tag')->insert($values);
	}


	/**
	 * @param int $id
	 * @param ArrayHash $values
	 * @throws Exception
	 */
	public function updateTag(int $id, ArrayHash $values): void
	{
		$tag = $this->database->table('tag')->get($id);
		if ($tag) {
			$tag->update($values);
		} else {
			throw new Exception('Tag not found');
		}
	}


	public function deleteTag(int $id): void
	{
		$tag = $this->database->table('tag')->get($id);
		if ($tag) {
			$tag->delete();
		} else {
			throw new Exception('Tag not found');
		}
	}
}
