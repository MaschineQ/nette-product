<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Form\CategoryFormFactory;
use App\AdminModule\Model\CategoryManager;
use Nette\Application\UI\Form;
use Nette\Database\ForeignKeyConstraintViolationException;

final class CategoryPresenter extends BasePresenter
{
	public function __construct(
		private ?int $categoryId,
		private CategoryFormFactory $categoryFormFactory,
		private CategoryManager $categoryManager,
	) {
		parent::__construct();
	}


	public function actionDefault(): void
	{
		$this->template->categories = $this->categoryManager->getCategories();
	}


	protected function createComponentCategoryForm(): Form
	{
		$form = $this->categoryFormFactory->create($this->categoryId);
		$form->onSuccess[] = function (Form $form) {
			$this->flashMessage('The category has been saved.', 'success');
			$this->redirect('default');
		};

		return $form;
	}


	public function actionEdit(int $id): void
	{
		$this->categoryId = $id;
		$category = $this->categoryManager->getCategory($id);

		if (!$category) {
			$this->error('Category not found');
		}

		$this['categoryForm']->setDefaults($category->toArray());
	}


	public function actionDelete(int $id): void
	{
		try {
			$this->categoryManager->deleteCategory($id);
			$this->flashMessage('The category has been deleted.', 'success');
		} catch (ForeignKeyConstraintViolationException) {
			$this->flashMessage('The category cannot be deleted. The category is assigned to the product.', 'danger');
		}

		$this->redirect('default');
	}
}
