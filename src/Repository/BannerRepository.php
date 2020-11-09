<?php

/*
 * This file is part of coaster.cloud.
 *
 * (c) Michel Chowanski <michel@chowanski.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repository;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class BannerRepository
{
    /** @var HttpClientInterface */
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getData(string $type): array
    {
        return [
            'Total length: 2.000 meter',
            'Total parks: 122',
            'Total attractions: 6372'
        ];
    }
}
