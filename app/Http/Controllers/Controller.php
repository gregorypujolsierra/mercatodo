<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function priceSearchRange(?int $min_price, ?int $max_price): array
    {
        if ($min_price or $max_price) {
            $price_range = array($min_price, $max_price);
            $min_price = min($price_range);
            $max_price = max($price_range);

            if ($min_price == $max_price) {
                if ($min_price < 10) {
                    $max_price += 10;
                } elseif ($min_price > 990) {
                    $min_price -= 10;
                } else {
                    $max_price += 10;
                }
            }
            $price_range = array($min_price, $max_price);
        } else {
            $price_range = array(null, null);
        }

        return $price_range;
    }
}
