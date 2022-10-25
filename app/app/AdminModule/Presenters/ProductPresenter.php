<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Form\ProductFormFactory;
use App\AdminModule\Model\ProductManager;
use App\External\ExchangeRateCnb;
use Nette\Application\UI\Form;
use Nette\Utils\DateTime;

final class ProductPresenter extends BasePresenter
{
	public function __construct(
		private ?int $productId,
		private ProductFormFactory $productFormFactory,
		private ProductManager $productManager,
		private ExchangeRateCnb $exchangeRateCnb,
	) {
		parent::__construct();
	}


	public function actionDefault(): void
	{
		$this->template->products = $this->productManager->getProducts();
		$this->template->exchangeRate = $this->exchangeRateCnb->getExchangeRateFromDb();
	}


	protected function createComponentProductForm(): Form
	{
		$form = $this->productFormFactory->create($this->productId);
		$form->onSuccess[] = function (Form $form) {
			$this->flashMessage('The product has been saved.', 'success');
			$this->redirect('default');
		};

		return $form;
	}


	public function actionEdit(int $id): void
	{
		$this->productId = $id;
		$product = $this->productManager->getProduct($id);
		if (!$product) {
			$this->error('Product not found');
		}
		$tags = $product->related('product_tag');

		$tagsArray = [];
		foreach ($tags as $tag) {
			$tagsArray[] = $tag->tag;
		}
		$tags = $tagsArray;

		/** @var DateTime $publishedAt */
		$publishedAt = $product->published_at;

		$this['productForm']->setDefaults([
			'name' => $product->name,
			'price' => $product->price,
			'category' => $product->category,
			'tag' => $tags,
			'active' => $product->active,
			'published_at' => DateTime::from($publishedAt)->format('Y-m-d'),
		]);
	}


	public function actionDelete(int $id): void
	{
		$this->productManager->deleteProduct($id);
		$this->flashMessage('The product has been deleted.', 'success');
		$this->redirect('default');
	}


	public function actionLoadExchangeRate(): void
	{
		try {
			$this->exchangeRateCnb->insertExchangeRate();
			$this->flashMessage('The exchange rate has been loaded.', 'success');
		} catch (\Exception $e) {
			$this->flashMessage('The exchange rate has not been loaded.', 'danger');
		}
		$this->redirect('default');
	}
}
