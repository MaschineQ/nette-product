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

		// přihlášení vyprší po 30 minutách neaktivity
		$this->user->setExpiration('30 minutes');

		if (!$this->user->isLoggedIn()) {
			if ($this->user->getLogoutReason() === UserStorage::LOGOUT_INACTIVITY) {
				$this->flashMessage('Z důvodu delší nečinnosti jste byli automaticky odhlášeni.', 'warning');
				$this->redirect('Sign:in', ['backlink' => $this->storeRequest()]);
			}
			$this->redirect('Sign:in', ['backlink' => $this->storeRequest()]);
		}
	}
}
