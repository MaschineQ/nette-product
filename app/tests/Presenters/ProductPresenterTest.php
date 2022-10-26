<?php

declare(strict_types=1);

use Nette\DI\Container;
use Tester\Assert;

$container = require __DIR__ . '/../bootstrap.php';


class ProductPresenterTest extends Tester\TestCase
{
	public function __construct(
		private Container $container,
	) {
	}


	public function testGetProducts(): void
	{
		$presenterFactory = $this->container->getByType('Nette\Application\IPresenterFactory');
		$presenter = $presenterFactory->createPresenter('Admin:Product');
		$presenter->autoCanonicalize = false;

		$request = new Nette\Application\Request('Admin:Product', 'GET', ['action' => 'default']);
		$response = $presenter->run($request);

		Assert::same(200, $presenter->getHttpResponse()->getCode());

		Assert::type('Nette\Application\Responses\TextResponse', $response);
		Assert::type('Nette\Bridges\ApplicationLatte\Template', $response->getSource());
	}


	public function testAdd(): void
	{
		$presenterFactory = $this->container->getByType('Nette\Application\IPresenterFactory');
		$presenter = $presenterFactory->createPresenter('Admin:Product');
		$presenter->autoCanonicalize = false;

		$request = new Nette\Application\Request('Admin:Product', 'GET', ['action' => 'add']);
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
		$presenter = $presenterFactory->createPresenter('Admin:product');
		$presenter->autoCanonicalize = false;

		$request = new Nette\Application\Request('Admin:Product', 'GET', ['action' => 'edit', 'id' => 1]);
		$response = $presenter->run($request);

		Assert::same(200, $presenter->getHttpResponse()->getCode());

		Assert::type('Nette\Application\Responses\TextResponse', $response);
		Assert::type('Nette\Bridges\ApplicationLatte\Template', $response->getSource());

		$html = (string) $response->getSource();

		$dom = Tester\DomQuery::fromHtml($html);

		Assert::true($dom->has('input[name="name"]'));
	}


	public function testEditProductNotFound(): void
	{
		$presenterFactory = $this->container->getByType('Nette\Application\IPresenterFactory');
		$presenter = $presenterFactory->createPresenter('Admin:Product');
		$request = new Nette\Application\Request('Admin:Product', 'GET', ['action' => 'edit', 'id' => 999999]);

		Assert::exception(function () use ($presenter, $request) {
			$presenter->run($request);
		}, 'Nette\Application\BadRequestException', 'Product not found');
	}


	public function testError(): void
	{
		$presenterFactory = $this->container->getByType('Nette\Application\IPresenterFactory');
		$presenter = $presenterFactory->createPresenter('Admin:Product');
		$presenter->autoCanonicalize = false;

		$request = new Nette\Application\Request('Admin:Product', 'GET', ['action' => 'error']);

		Assert::exception(function () use ($presenter, $request) {
			$presenter->run($request);
		}, 'Nette\Application\BadRequestException');
	}
}

$test = new ProductPresenterTest($container);
$test->run();
