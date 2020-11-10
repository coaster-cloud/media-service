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

interface BannerInterface
{
    /**
     * Get banner key for url
     *
     * @return string
     */
    public static function getKey(): string;

    /**
     * Create banner image
     *
     * @param array $stats
     * @param string $assetPath
     *
     * @return resource
     */
    public function create(array $stats, string $assetPath);
}
