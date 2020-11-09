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

class LogoV1Banner extends AbstractBanner
{
    public static function getKey(): string
    {
        return 'logo_v1';
    }

    public function getFilename(): string
    {
        return 'banner/logo_v1.png';
    }
}
