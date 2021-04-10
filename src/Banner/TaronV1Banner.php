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

        $textFontBold = $assetPath . 'fonts/nunito/Bold.ttf';
        $textFontLight = $assetPath . 'fonts/nunito/Light.ttf';
        $textColorGrey = imagecolorallocate($image, 100, 100, 100);

        $count = $stats['counts']['totalCoasterAttractions'];
        $offset = strlen((string) $count) * 8;
        imagettftext($image, 8, 0, 325, 28, $textColorGrey, $textFontLight, 'COASTER COUNT');
        imagettftext($image, 20, 0, 370 - $offset, 58, $textColorGrey, $textFontBold, $count);

        return $image;
    }
}
