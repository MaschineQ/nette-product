<?php

declare(strict_types=1);

namespace App\AdminModule\Form;


use App\AdminModule\Model\CategoryManager;
use App\AdminModule\Model\ProductManager;
use App\AdminModule\Model\TagManager;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;
use Nette\Utils\DateTime;

class ProductFormFactory
{
	private ?int $productId;


	public function __construct(
		private FormFactory $formFactory,
		private ProductManager $productManager,
		private CategoryManager $categoryManager,
		private TagManager $tagManager,
	) {
	}


	public function create(?int $productId): Form
	{
		$this->productId = $productId;
		$form = $this->formFactory->create();

		$categoriesForSelect = $this->categoryManager->getCategoriesForSelect();
		$tagsForSelect = $this->tagManager->getTagsForSelect();

		$form->addText('name', 'Name')
			->setRequired('Please enter the name of the product.');
		$form->addText('published_at', 'Published at')
			->setHtmlType('date')
			->setHtmlAttribute('id', 'datepicker')
			->setRequired('Please enter the date of publication.');
		$form->addText('price', 'Price')
			->addRule(Form::FLOAT, 'Price must be a number.')
			->setNullable()
			->setRequired('Please enter the price of the product.');

		if ($categoriesForSelect) {
			$form->addSelect('category', 'Category', $categoriesForSelect)
				->setPrompt('Select category')
				->setRequired('Please select the category of the product.');
		} else {
			$form->addError('You have to create category first. Go to category section');
		}

		if ($tagsForSelect) {
			$form->addMultiSelect('tag', 'Tags', $tagsForSelect)
				->setRequired('Please select the tags of the product.');
		} else {
			$form->addError('You have to create tag first. Go to tag section');
		}

		$form->addCheckbox('active', 'Active')
					->setDefaultValue(true);
		$form->addSubmit('save', 'Save');

		$form->onValidate[] = [$this, 'validateProductForm']; /** @phpstan-ignore-line */
		$form->onSuccess[] = [$this, 'productFormSucceeded']; /** @phpstan-ignore-line */

		return $form;
	}


	public function validateProductForm(Form $form, ArrayHash $values): void
	{
		if (!$this->validateDate($form->getValues()->published_at)) {
			$form['published_at']->addError('Date is not valid'); /** @phpstan-ignore-line */
		}

	}


	public function productFormSucceeded(Form $form, ArrayHash $values): void
	{
		$productId = $this->productId;
		assert(is_array($values['tag']));
		$tags = $values['tag'];
		unset($values['tag']);

		if ($productId) {
			$this->productManager->updateProduct($productId, $values, $tags);
		} else {
			$this->productManager->addProduct($values, $tags);
		}
	}


	private function validateDate(string $date, string $format = 'Y-m-d'): bool
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
}
