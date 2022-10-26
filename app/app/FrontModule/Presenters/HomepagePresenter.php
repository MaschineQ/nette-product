<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\FrontModule\Model\ProductManager;
use Nette\Application\UI\Presenter;


final class HomepagePresenter extends Presenter
{
	public function __construct(
		private ProductManager $productManager,
	) {
	}


	public function renderDefault(): void
	{
		$this->template->products = $this->productManager->getLatestProducts();
	}
}
