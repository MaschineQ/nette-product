<?php

declare(strict_types=1);

namespace App\AdminModule\Model;

use Nette\Database\Explorer;

class ProductTagManager
{
	public function __construct(
		private Explorer $database,
	) {

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
