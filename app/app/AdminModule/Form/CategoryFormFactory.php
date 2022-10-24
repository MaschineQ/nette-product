<?php

declare(strict_types=1);

namespace App\AdminModule\Form;


use App\AdminModule\Model\CategoryManager;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class CategoryFormFactory
{
	public function __construct(
		private ?int $categoryId,
		private FormFactory $formFactory,
		private CategoryManager $categoryManager,
	) {
	}


	public function create(?int $categoryId): Form
	{
		$this->categoryId = $categoryId;
		$form = $this->formFactory->create();

		$form->addText('name', 'Name')
			->setRequired();
		$form->addSubmit('save', 'Save');
		$form->onSuccess[] = [$this, 'categoryFormSucceededFormSucceeded'];

		return $form;
	}


	public function categoryFormSucceeded(Form $form, ArrayHash $values): void
	{
		$categoryId = $this->categoryId;

		if ($categoryId) {
			$this->categoryManager->updateCategory($categoryId, $values);
		} else {
			$this->categoryManager->addCategory($values);

		}
	}
}
