<?php

declare(strict_types=1);

use App\External\ExchangeRateCnb;
use Nette\DI\Container;
use Nette\Utils\DateTime;
use Tester\Assert;

$container = require __DIR__ . '/../bootstrap.php';

class ExchangeRateCnbTest extends Tester\TestCase
{
	public function __construct(
		private Container $container,
	) {
	}


	public function testUrl(): void
	{
		$actualDay = new DateTime();
		$url = 'https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt?date=' . $actualDay->format('d.m.Y');
		$content = file_get_contents($url);

		Assert::same('HTTP/1.1 200 200', $http_response_header[0]);
		Assert::true($content !== false);
	}


	public function testGetExchangeRate(): void
	{
		$exchangeRateCnb = $this->container->getByType(ExchangeRateCnb::class);
		$exchangeRate = $exchangeRateCnb->getExchangeRate();

		Assert::type('float', $exchangeRate);
		Assert::notNull($exchangeRate);
	}
}

$test = new ExchangeRateCnbTest($container);
$test->run();
