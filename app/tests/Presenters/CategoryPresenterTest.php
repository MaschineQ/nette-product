<?php

declare(strict_types=1);

use Nette\DI\Container;
use Tester\Assert;

$container = require __DIR__ . '/../bootstrap.php';


class CategoryPresenterTest extends Tester\TestCase
{
	public function __construct(
		private Container $container,
	) {
	}

    public function setUp()
    {
        $user = $this->container->getByType(\Nette\Security\User::class);
        $user->login('admin', 'admin');
    }

    public function testGetCategories(): void
	{
		$presenterFactory = $this->container->getByType('Nette\Application\IPresenterFactory');
		$presenter = $presenterFactory->createPresenter('Admin:Category');
		$presenter->autoCanonicalize = false;

		$request = new Nette\Application\Request('Admin:Category', 'GET', ['action' => 'default']);
		$response = $presenter->run($request);

		Assert::same(200, $presenter->getHttpResponse()->getCode());

		Assert::type('Nette\Application\Responses\TextResponse', $response);
		Assert::type('Nette\Bridges\ApplicationLatte\Template', $response->getSource());
	}


	public function testAdd(): void
	{
		$presenterFactory = $this->container->getByType('Nette\Application\IPresenterFactory');
		$presenter = $presenterFactory->createPresenter('Admin:Category');
		$presenter->autoCanonicalize = false;

		$request = new Nette\Application\Request('Admin:Category', 'GET', ['action' => 'add']);
		$response = $presenter->run($request);

		Assert::same(200, $presenter->getHttpResponse()->getCode());

		Assert::type('Nette\Application\Responses\TextResponse', $response);
		Assert::type('Nette\Bridges\ApplicationLatte\Template', $response->getSource());

		$html = (string) $response->getSource();

		$dom = Tester\DomQuery::fromHtml($html);

		Assert::true($dom->has('input[name="name"]'));
	}


	public function testEdit(): void
	{
		$presenterFactory = $this->container->getByType('Nette\Application\IPresenterFactory');
		$presenter = $presenterFactory->createPresenter('Admin:Category');
		$presenter->autoCanonicalize = false;

		$request = new Nette\Application\Request('Admin:Category', 'GET', ['action' => 'edit', 'id' => 1]);
		$response = $presenter->run($request);

		Assert::same(200, $presenter->getHttpResponse()->getCode());

		Assert::type('Nette\Application\Responses\TextResponse', $response);
		Assert::type('Nette\Bridges\ApplicationLatte\Template', $response->getSource());

		$html = (string) $response->getSource();

		$dom = Tester\DomQuery::fromHtml($html);

		Assert::true($dom->has('input[name="name"]'));
	}


	public function testEditCategoryNotFound(): void
	{
		$presenterFactory = $this->container->getByType('Nette\Application\IPresenterFactory');
		$presenter = $presenterFactory->createPresenter('Admin:Category');
		$request = new Nette\Application\Request('Admin:Category', 'GET', ['action' => 'edit', 'id' => 999999]);

		Assert::exception(function () use ($presenter, $request) {
			$presenter->run($request);
		}, 'Nette\Application\BadRequestException', 'Category not found');
	}


	public function testError(): void
	{
		$presenterFactory = $this->container->getByType('Nette\Application\IPresenterFactory');
		$presenter = $presenterFactory->createPresenter('Admin:Category');
		$presenter->autoCanonicalize = false;

		$request = new Nette\Application\Request('Admin:Category', 'GET', ['action' => 'error']);

		Assert::exception(function () use ($presenter, $request) {
			$presenter->run($request);
		}, 'Nette\Application\BadRequestException');
	}
}

$test = new CategoryPresenterTest($container);
$test->run();
