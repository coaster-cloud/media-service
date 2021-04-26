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

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BannerRepository
{
    /** @var HttpClientInterface */
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getData(string $username): array
    {
        $response = $this->client->request('POST', 'https://data.coaster.cloud/v1', [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'json' => [
                'query' => '42b58a5f-0f54-4aab-a68d-471b29284ba5',
                'variables' => [
                    'username' => $username
                ]
            ]
        ]);

        $rawData = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        if ($rawData['data']['account'] === null) {
            throw new NotFoundHttpException(sprintf('Unknown username `%s`', $username));
        }

        $summary = [
            'counts' => [],
            'rideFacts' => []
        ];

        foreach ($rawData['data']['account']['rideStatistic']['rideFacts'] as $item) {
            $summary['rideFacts'][$item['key']] = $item['value'];
        }

        foreach ($rawData['data']['account']['rideStatistic']['counts'] as $item) {
            $summary['counts'][$item['key']] = $item['value'];
        }

        return $summary;
    }
}
