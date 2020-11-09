<?php

/*
 * This file is part of coaster.cloud.
 *
 * (c) Michel Chowanski <michel@chowanski.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Banner;

abstract class AbstractBanner implements BannerInterface
{
    public function getTextPositions(): array
    {
        return [
            ['x' => 65, 'y' => 15],
            ['x' => 65, 'y' => 35],
            ['x' => 65, 'y' => 55],
        ];
    }

    public function getTextColor(): array
    {
        return ['red' => 100, 'green' => 100, 'blue' => 100];
    }

    public function getTextSize(): int
    {
        return 10;
    }

    public function getTextFont(): string
    {
        return 'fonts/nunito/Bold.ttf';
    }

    public function extendBanner($image): void
    {
    }
}
