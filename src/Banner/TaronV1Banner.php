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

class TaronV1Banner extends AbstractBanner
{
    public static function getKey(): string
    {
        return 'taron_v1';
    }

    public function getFilename(): string
    {
        return 'banner/taron_v1.jpg';
    }

    public function extendBanner($image): void
    {
        $black = imagecolorallocatealpha($image, 0, 0, 0, 50);
        imagefilledrectangle($image, 0, 0, 555, 80, $black);
    }

    public function getTextColor(): array
    {
        return ['red' => 255, 'green' => 255, 'blue' => 255];
    }

    public function getTextSize(): int
    {
        return 12;
    }

    public function getTextPositions(): array
    {
        return [
            ['x' => 10, 'y' => 20],
            ['x' => 10, 'y' => 45],
            ['x' => 10, 'y' => 70],
        ];
    }
}
