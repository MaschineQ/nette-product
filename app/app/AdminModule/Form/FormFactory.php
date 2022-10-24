<?php

declare(strict_types=1);

namespace App\AdminModule\Form;

use Contributte\FormsBootstrap\BootstrapForm;
use Contributte\FormsBootstrap\Enums\BootstrapVersion;
use Nette;
use Nette\Application\UI\Form;

final class FormFactory
{
	use Nette\SmartObject;

	public function create(): Form
	{
        BootstrapForm::switchBootstrapVersion(BootstrapVersion::V5);
		return new BootstrapForm();
	}
}
