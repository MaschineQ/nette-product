<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Model\TagManager;
use Nette\Application\UI\Presenter;


final class TagPresenter extends Presenter
{
	public function __construct(
		private TagManager $tagManager,
	) {
	}


	public function renderDefault(): void
	{
		$this->template->tags = $this->tagManager->getTags();
	}
}
