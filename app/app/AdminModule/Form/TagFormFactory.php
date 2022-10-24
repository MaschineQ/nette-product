<?php

declare(strict_types=1);

namespace App\AdminModule\Form;


use App\AdminModule\Model\TagManager;
use Nette\Application\UI\Form;
use Nette\Utils\ArrayHash;

class TagFormFactory
{
	public function __construct(
		private ?int        $tagId,
		private FormFactory $formFactory,
		private TagManager  $tagManager,
	) {
	}


	public function create(?int $tagId): Form
	{
		$this->tagId = $tagId;
		$form = $this->formFactory->create();

		$form->addText('name', 'Name')
			->setRequired();
		$form->addSubmit('save', 'Save');
		$form->onSuccess[] = [$this, 'tagFormSucceeded']; /** @phpstan-ignore-line */

		return $form;
	}


	public function tagFormSucceeded(Form $form, ArrayHash $values): void
	{
		$tagId = $this->tagId;

		if ($tagId) {
			$this->tagManager->updateTag($tagId, $values);
		} else {
			$this->tagManager->addTag($values);

		}
	}
}
