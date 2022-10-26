<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Form\SignInFormFactory;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;


final class SignPresenter extends Presenter
{
	/** @persistent */
	public string $backlink = '';


	public function __construct(
		private SignInFormFactory $signInFactory,
	) {
		parent::__construct();
	}


	/**
	 * Sign-in form factory.
	 */
	protected function createComponentSignInForm(): Form
	{
		return $this->signInFactory->create(function (): void {
			$this->restoreRequest($this->backlink);
			$this->redirect('Homepage:');
		});
	}


	public function actionOut(): void
	{
		$this->getUser()->logout();
		$this->redirect('Homepage:');
	}
}
