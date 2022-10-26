<?php

declare(strict_types=1);

namespace App\AdminModule\Form;

use Nette;

use Nette\Application\UI\Form;
use Nette\Security\User;

final class SignInFormFactory
{
	use Nette\SmartObject;

	public function __construct(
		private FormFactory $formFactory,
		private User $user,
	) {
	}


	public function create(callable $onSuccess): Form
	{
		$form = $this->formFactory->create();
		$form->addText('username', 'Username')
			->setHtmlAttribute('placeholder', 'User name')
			->setRequired('Please enter your username.');

		$form->addPassword('password', 'Password')
			->setHtmlAttribute('placeholder', 'Password')
			->setRequired('Please enter your password.');

		$form->addCheckbox('remember', 'Keep me signed in');

		$form->addSubmit('send', 'Login');

		$form->onSuccess[] = function (Form $form, \stdClass $values) use ($onSuccess): void { /** @phpstan-ignore-line */
			try {
				$this->user->setExpiration($values->remember ? '14 days' : '20 minutes');
				$this->user->login($values->username, $values->password);
			} catch (Nette\Security\AuthenticationException $e) {
				$form->addError('The username or password you entered is incorrect.');
				return;
			}
			$onSuccess();
		};

		return $form;
	}
}
