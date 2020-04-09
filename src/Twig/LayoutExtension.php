<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class LayoutExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('price', [$this, 'price'], ["is_safe" => ["html"]]),
            new TwigFilter('prices', [$this, 'price'], ["is_safe" => ["html"]]),
        ];
    }

    public function price($price, $currency = "€")
    {
        if ($price == '') return null;
        return number_format($price, 2,'.', ' ').' '.$currency;
    }
}