<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Form\ProductFormFactory;
use App\AdminModule\Model\ProductManager;
use Nette\Application\UI\Form;

class ProductPresenter extends BasePresenter
{
	public function __construct(
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
		$form = $this->productFormFactory->create();
		$form->onSuccess[] = function (Form $form) {
			$this->flashMessage('Příspěvek byl úspěšně publikován..', 'success');
			$this->redirect('default');
		};

		return $form;
	}


	public function actionEdit(int $id): void
	{
	}


	public function actionAdd(): void
	{

	}
}
