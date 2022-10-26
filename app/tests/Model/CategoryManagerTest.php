<?php

declare(strict_types=1);

use App\AdminModule\Model\CategoryManager;
use Nette\DI\Container;
use Tester\Assert;

$container = require __DIR__ . '/../bootstrap.php';

class CategoryManagerTest extends Tester\TestCase
{
	public function __construct(
		private Container $container,
	) {
	}


	public function testGetCategories(): void
	{
		$categoryManager = $this->container->getByType(CategoryManager::class);
		$categories = $categoryManager->getCategories();

		$cat = [];
		foreach ($categories as $category) {
			$cat[] = $category->name;
		}

		Assert::contains('category 1', $cat);
	}


	public function testGetCategory(): void
	{
		$categoryManager = $this->container->getByType(CategoryManager::class);
		$category = $categoryManager->getCategory(1);

		Assert::same('category 1', $category->name);
	}


	public function testGetCategoriesForSelect(): void
	{
		$categoryManager = $this->container->getByType(CategoryManager::class);
		$category = $categoryManager->getCategoriesForSelect();

		Assert::same([1 => 'category 1', 2 => 'category 2'], array_slice($category, 0, 2, true));
	}
}

$test = new CategoryManagerTest($container);
$test->run();
