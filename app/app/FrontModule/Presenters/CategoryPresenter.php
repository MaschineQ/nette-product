<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Model\CategoryManager;
use Nette\Application\UI\Presenter;


final class CategoryPresenter extends Presenter
{
	public function __construct(
		private CategoryManager $categoryManager,
	) {
	}


	public function renderDefault(): void
	{
		$this->template->categories = $this->categoryManager->getCategories();
	}
}
