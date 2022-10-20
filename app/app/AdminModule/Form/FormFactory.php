<?php

declare(strict_types=1);

namespace App\AdminModule\Form;

use Nette\Application\UI\Form;

final class FormFactory
{
	public function create(): Form
	{
		return new Form;
	}
}
