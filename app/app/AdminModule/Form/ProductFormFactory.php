<?php

declare(strict_types=1);

namespace App\AdminModule\Form;


use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class ProductFormFactory
{
	public function create(): Form
	{
		$form = new Form();

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
		$form->addMultiSelect('tags', 'Tags')
			->setItems([
				'1' => 'Tag 1',
				'2' => 'Tag 2',
			])
			->setRequired();
		$form->addCheckbox('active', 'Active');
		$form->addSubmit('save', 'Save');
		$form->onSuccess[] = [$this, 'productFormSucceeded'];

		return $form;
	}


	public function productFormSucceeded(Form $form, ArrayHash $values): void
	{
	}
}
