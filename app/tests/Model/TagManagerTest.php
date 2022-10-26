<?php

declare(strict_types=1);

use App\AdminModule\Model\TagManager;
use Nette\DI\Container;
use Tester\Assert;

$container = require __DIR__ . '/../bootstrap.php';

class TagManagerTest extends Tester\TestCase
{
	public function __construct(
		private Container $container,
	) {
	}


	public function testGetTags(): void
	{
		$tagManager = $this->container->getByType(TagManager::class);
		$tags = $tagManager->getTags();

		$tag = [];
		foreach ($tags as $item) {
			$tag[] = $item->name;
		}

		Assert::contains('tag 1', $tag);
	}


	public function testGetTag(): void
	{
		$tagManager = $this->container->getByType(TagManager::class);
		$tag = $tagManager->getTag(1);

		Assert::same('tag 1', $tag->name);
	}


	public function testGetTagForSelect(): void
	{
		$tagManager = $this->container->getByType(TagManager::class);
		$tag = $tagManager->getTagsForSelect();

		Assert::same([1 => 'tag 1', 2 => 'tag 2'], array_slice($tag, 0, 2, true));
	}
}

$test = new TagManagerTest($container);
$test->run();
