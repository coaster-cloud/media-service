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

class TaronV1Banner implements BannerInterface
{
    public static function getKey(): string
    {
        return 'taron_v1';
    }

    public function create(array $stats, string $assetPath)
    {
        $image = imagecreatefromjpeg($assetPath . 'banner/taron_v1.jpg');

        $textSize = 20;
        $textFont = $assetPath . 'fonts/nunito/Bold.ttf';
        $textColor = imagecolorallocate($image, 100, 100, 100);

        $offset = strlen((string) $stats['total_attractions_unique']) * 8;
        imagettftext($image, $textSize, 0, 370 - $offset, 60, $textColor, $textFont, $stats['total_attractions_unique']);

        return $image;
    }
}
