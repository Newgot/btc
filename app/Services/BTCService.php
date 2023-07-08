<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class BTCService
{
    /**
     * Вывод курса валют
     * @param Request $request
     * @return Collection
     */
    public function rates(Request $request): Collection
    {
        $rates = $this->getRates();
        $currency = $request->get('currency');
        return !empty($currency)
            ? $rates->filter(function ($rate, $key) use ($currency) {
                return $key === $currency;
            })
            : $rates;
    }

    /**
     * Вывод конвертации
     * @param Request $request
     * @return array
     */
    public function convert(Request $request): array
    {
        $rates = $this->getRates();
        $from = $request->get('currency_from');
        $to = $request->get('currency_to');
        $value = (float)$request->get('value');
        $rate = 0;
        $convertedValue = 0;
        if ($from === 'BTC') {
            $rate = (float)$rates[$to];
            $convertedValue = $this->fromBTC($rate, $value);
        } elseif ($to === 'BTC') {
            $rate = (float)$rates[$from];
            $convertedValue = $this->toBTC((float)$rates[$from], $value);
        }
        return [
            'convert_from' => $from,
            'convert_to' => $to,
            'value' => $value,
            'converted_value' => $convertedValue,
            'rate' => $rate,
        ];
    }

    /**
     * Получение списка валют
     * @return Collection
     */
    protected function getRates(): Collection
    {
        $response = Http::get('https://blockchain.info/ticker');
        return $response
            ->collect()
            ->map(function ($rate) {
                return $this->getPrice($rate['last']);
            })
            ->sort();
    }

    /**
     * Получение цены за BTC
     * @param float $price
     * @return float
     */
    protected function getPrice(float $price): float
    {
        return round($price + $price * config('btc.commission'), 2);
    }

    /**
     * Конвертация BTC в валюту
     * @param float $rate
     * @param float $value
     * @return float
     */
    protected function fromBTC(float $rate, float $value): float
    {
        return (float)bcmul($value, $rate, 2);
    }

    /**
     * Конвертация валюты в BTC
     * @param float $rate
     * @param float $value
     * @return float
     */
    protected function toBTC(float $rate, float $value): float
    {
        return (float)bcdiv($value, $rate, 10);
    }
}
