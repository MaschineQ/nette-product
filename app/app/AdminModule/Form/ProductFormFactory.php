<?php

declare(strict_types=1);

namespace App\AdminModule\Form;


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
	) {
	}


	public function create(?int $productId): Form
	{
		$this->productId = $productId;
		$form = $this->formFactory->create();

		$form->addText('name', 'Name')
			->setRequired();
		$form->addText('price', 'Price')
			->addRule(Form::FLOAT, 'Price must be a number.')
			->setNullable()
			->setRequired();
		$form->addSelect('category', 'Category', [
			'1' => 'Category 1',
			'2' => 'Category 2',
		])
			->setRequired();
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
