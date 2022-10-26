<?php

declare(strict_types=1);

use App\AdminModule\Model\ProductManager;
use Nette\DI\Container;
use Tester\Assert;

$container = require __DIR__ . '/../bootstrap.php';

class ProductManagerTest extends Tester\TestCase
{
	public function __construct(
		private Container $container,
	) {
	}


	public function testGetProducts(): void
	{
		$productManager = $this->container->getByType(ProductManager::class);
		$products = $productManager->getProducts();

		$product = [];
		foreach ($products as $item) {
			$product[] = $item->name;
		}

		Assert::contains('Product 1', $product);
	}


	public function testGetProduct(): void
	{
		$productManager = $this->container->getByType(ProductManager::class);
		$product = $productManager->getProduct(1);

		Assert::same('Product 1', $product->name);
	}
}

$test = new ProductManagerTest($container);
$test->run();
