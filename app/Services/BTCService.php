<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class BTCService
{
    /**
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

    public function convert(Request $request)
    {
        $rates = $this->getRates();
        $from = (float)$rates[$request->get('currency_from')];
        $to = (float)$rates[$request->get('currency_to')];
        $value = (float)$request->get('value');
        dump(bcmul($from, $value, 10));
        dump($to);
    }

    /**
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

    protected function getPrice(float $price): float
    {
        return round($price + $price * config('btc.commission'), 2);
    }
}
