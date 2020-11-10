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

use InvalidArgumentException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BannerRepository
{
    /** @var HttpClientInterface */
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getData(?string $category, string $username): array
    {
        $response = $this->client->request('POST', 'https://coaster.cloud/oci/v1', [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'body' => [
                'query' => <<<'EOL'
                    query ($username: String!, $filter: CountStatisticFilter) {
                      profile(username: $username) {
                        statistic(filter: $filter) {
                          summary {
                            key, text
                          }
                        }
                      }
                    }
                EOL,
                'variables' => [
                    'username' => $username,
                    'filter' => [
                        'category' => $category
                    ]
                ]
            ]
        ]);

        $rawData = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        if ($rawData['data']['profile'] === null) {
            throw new InvalidArgumentException(sprintf('Unknown username `%s`', $username));
        }

        $summary = [];
        foreach ($rawData['data']['profile']['statistic']['summary'] as $item) {
            $summary[$item['key']] = $item['text'];
        }

        return $summary;
    }
}
