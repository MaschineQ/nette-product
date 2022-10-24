<?php

declare(strict_types=1);

namespace App\AdminModule\Form;


use App\AdminModule\Model\CategoryManager;
use App\AdminModule\Model\ProductManager;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;
use Nette\Utils\Json;

class ProductFormFactory
{
	private ?int $productId;


	public function __construct(
		private FormFactory $formFactory,
		private ProductManager $productManager,
		private CategoryManager $categoryManager,
	) {
	}


	public function create(?int $productId): Form
	{
		$this->productId = $productId;
		$form = $this->formFactory->create();

		$categoriesForSelect = $this->categoryManager->getCategoriesForSelect();

		$form->addText('name', 'Name')
			->setRequired();
		$form->addText('price', 'Price')
			->addRule(Form::FLOAT, 'Price must be a number.')
			->setNullable()
			->setRequired();

		if ($categoriesForSelect) {
			$form->addSelect('category', 'Category', $categoriesForSelect)
				->setPrompt('Select category')
				->setRequired();
		} else {
			$form->addError('You have to create category first. Go to category section');
		}


		$form->addMultiSelect('tag', 'Tags')
			->setItems([
				'1' => 'Tag 1',
				'2' => 'Tag 2',
			])
			->setRequired();
		$form->addCheckbox('active', 'Active');
		$form->addSubmit('save', 'Save');
		$form->onSuccess[] = [$this, 'productFormSucceeded']; /** @phpstan-ignore-line */

		return $form;
	}


	public function productFormSucceeded(Form $form, ArrayHash $values): void
	{
		$productId = $this->productId;
		$values['tag'] = Json::encode($values['tag']);

		if ($productId) {
			$this->productManager->updateProduct($productId, $values);
		} else {
			$this->productManager->addProduct($values);

		}
	}
}
