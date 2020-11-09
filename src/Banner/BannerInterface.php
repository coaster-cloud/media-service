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
     * Get filename
     *
     * @return string
     */
    public function getFilename(): string;

    /**
     * Get text positions for 3 text
     *
     * @return array
     */
    public function getTextPositions(): array;

    /**
     * Get text color
     *
     * @return array
     */
    public function getTextColor(): array;

    /**
     * Get text font
     *
     * @return string
     */
    public function getTextFont(): string;

    /**
     * Get text size
     *
     * @return int
     */
    public function getTextSize(): int;

    /**
     * Add additional operations for banner
     *
     * @param resource $image
     */
    public function extendBanner($image): void;
}
