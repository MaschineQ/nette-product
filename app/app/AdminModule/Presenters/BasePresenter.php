<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use Nette\Application\UI\Presenter;
use Nette\Security\UserStorage;

class BasePresenter extends Presenter
{
	public function startup(): void
	{
		parent::startup();

		if (!$this->user->isLoggedIn()) {
			if ($this->user->getLogoutReason() === UserStorage::LOGOUT_INACTIVITY) {
				$this->flashMessage('You have been signed out due to inactivity. Please sign in again.', 'warning');
				$this->redirect('Sign:in', ['backlink' => $this->storeRequest()]);
			}
			$this->redirect('Sign:in', ['backlink' => $this->storeRequest()]);
		}
	}
}
