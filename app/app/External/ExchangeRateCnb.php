<?php

declare(strict_types=1);

namespace App\External;

use Nette\Database\Explorer;
use Nette\Utils\DateTime;

class ExchangeRateCnb
{
	public function __construct(
		private Explorer $database,
	) {
	}


	public function getExchangeRate(string $currency = 'EUR'): float
	{
		$actualDay = new DateTime();
		$url = 'https://www.cnb.cz/cs/financni_trhy/devizovy_trh/kurzy_devizoveho_trhu/denni_kurz.txt?date=' . $actualDay->format('d.m.Y');
		bdump($url);
		/** @var string $data */
		$data = file_get_contents($url);

		$output = explode("\n", $data);

		// odstranění prvního řádku - datum
		// odstranění posledního řádku - nic neobsahuje
		// odstranění druhého řádku - legenda pro CSV
		unset($output[0], $output[count($output)], $output[1]);

		$exchangeRate = [];
		foreach ($output as $row) {
			$data = explode('|', $row);
			$exchangeRate[trim($data[3])] = str_replace(',', '.', trim($data[4]));
		}
		return (float) $exchangeRate[$currency];
	}


	public function insertExchangeRate(string $currency = 'EUR'): void
	{
		$amount = $this->getExchangeRate($currency);
		$this->database->table('exchange_rate')->insert([
			'currency' => $currency,
			'amount' => $amount,
		]);
	}


	public function getExchangeRateFromDb(string $currency = 'EUR'): ?float
	{
		$row = $this->database->table('exchange_rate')->where('currency', $currency)->order('id DESC')->limit(1)->fetch();
		if ($row) {
			assert(is_float($row->amount));
			return $row->amount;
		}
		return null;
	}
}
