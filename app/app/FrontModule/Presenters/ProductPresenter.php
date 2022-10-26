<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Model\ProductManager;
use Nette\Application\UI\Presenter;


final class ProductPresenter extends Presenter
{
	public function __construct(
		private ProductManager $productManager,
	) {
	}


	public function renderDefault(): void
	{
		$this->template->products = $this->productManager->getProducts();
	}


	public function actionShow(int $id): void
	{
		$product = $this->productManager->getProduct($id);
		if ($product) {
			$this->template->product = $product;
		} else {
			$this->error('Product not found');
		}
	}


	public function actionTag(int $id): void
	{
		$this->template->products = $this->productManager->getProductsByTag($id);
		$this->template->tag = $this->productManager->getProductTag($id);
	}


	public function actionCategory(int $id): void
	{
		$this->template->products = $this->productManager->getProductsByCategory($id);
		$this->template->category = $this->productManager->getProductCategory($id);
	}
}
