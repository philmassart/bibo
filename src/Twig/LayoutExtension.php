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
            new TwigFilter('alcohol', [$this, 'alcohol'], ["is_safe" => ["html"]]),
            new TwigFilter('capacity', [$this, 'capacity'], ["is_safe" => ["html"]]),
        ];
    }

    public function price($price, $currency = "€")
    {
        if ($price == '') return null;
        return number_format($price, 2,',', ' ').' '.$currency;
    }

    public function alcohol($alcohol, $percent = "%")
    {
        if ($alcohol == '') return null;
        return number_format($alcohol, 1,',', ' ').' '.$percent;
    }

    public function capacity($capacity)
    {
        if ($capacity == '') return null;
        return number_format($capacity, 1,',', ' ');
    }
}