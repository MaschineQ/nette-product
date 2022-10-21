<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Form\ProductFormFactory;
use App\AdminModule\Model\ProductManager;
use Nette\Application\UI\Form;
use Nette\Utils\Json;

final class ProductPresenter extends BasePresenter
{
	public function __construct(
		private ?int $productId,
		private ProductFormFactory $productFormFactory,
		private ProductManager $productManager,
	) {
		parent::__construct();
	}


	public function actionDefault(): void
	{
		$this->template->products = $this->productManager->getProducts();
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

		/** @var string $tag */
		$tag = $product->tag;

		$this['productForm']->setDefaults([
			'name' => $product->name,
			'price' => $product->price,
			'category' => $product->category,
			'tag' => Json::decode($tag),
			'active' => $product->active,
		]);
	}


	public function actionDelete(int $id): void
	{
		$this->productManager->deleteProduct($id);
		$this->flashMessage('The product has been deleted.', 'success');
		$this->redirect('default');
	}
}
