<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Form\TagFormFactory;
use App\AdminModule\Model\TagManager;
use Nette\Application\UI\Form;

final class TagPresenter extends BasePresenter
{
	public function __construct(
		private ?int $tagId,
		private TagFormFactory $tagFormFactory,
		private TagManager $tagManager,
	) {
		parent::__construct();
	}


	public function actionDefault(): void
	{
		$this->template->tags = $this->tagManager->getTags();
	}


	protected function createComponentTagForm(): Form
	{
		$form = $this->tagFormFactory->create($this->tagId);
		$form->onSuccess[] = function (Form $form) {
			$this->flashMessage('The Tag has been saved.', 'success');
			$this->redirect('default');
		};

		return $form;
	}


	public function actionEdit(int $id): void
	{
		$this->tagId = $id;
		$tag = $this->tagManager->getTag($id);

		if (!$tag) {
			$this->error('Tag not found');
		}

		$this['tagForm']->setDefaults($tag->toArray());
	}


	public function actionDelete(int $id): void
	{
		$this->tagManager->deleteTag($id);
		$this->flashMessage('The Tag has been deleted.', 'success');
		$this->redirect('default');
	}
}
