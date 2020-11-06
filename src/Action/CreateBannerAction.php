<?php

/*
 * This file is part of coaster.cloud.
 *
 * (c) Michel Chowanski <michel@chowanski.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Action;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CreateBannerAction
{
    /** @var HttpClientInterface */
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function __invoke(string $username, Request $request): BinaryFileResponse
    {
        $locale = $request->query->get('locale', 'en');
        $background = $this->getBackgroundSetting($request->query->get('bg', 'logo_v1'));

        switch ($background['type']) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg(__DIR__ . '/../../assets/banner/' . $background['filename']);
                break;

            case IMAGETYPE_PNG:
                $image = imagecreatefrompng(__DIR__ . '/../../assets/banner/' . $background['filename']);
                break;

            default:
                throw new InvalidArgumentException(sprintf('Unknown image type `%s`', $background['type']));
        }

        if ($background['flip'] === true) {
            imageflip($image, IMG_FLIP_HORIZONTAL);
        }

        $font = __DIR__ . '/../../assets/fonts/nunito/Bold.ttf';
        $textColor = imagecolorallocate(
            $image,
            $background['color']['red'],
            $background['color']['green'],
            $background['color']['blue']
        );

        // Transparent background
        if ($background['background']) {
            $black = imagecolorallocatealpha($image, 0, 0, 0, 50);
            imagefilledrectangle($image, 0, 0, 555, 80, $black);
        }

        // TODO: Dynamically
        $data = [
            'Total length: 2.000 meter',
            'Total parks: 122',
            'Total attractions: 6372'
        ];

        $index = 0;
        foreach ($data as $text) {
            imagettftext(
                $image,
                10,
                0,
                $background['positions'][$index]['x'],
                $background['positions'][$index]['y'],
                $textColor,
                $font,
                $text
            );

            $index++;
        }

        imagettftext($image, 7, 0, 325, 75, $textColor, $font, 'powered by coaster.cloud');

        $tempFilePath = tempnam(sys_get_temp_dir(), 'img') . '.png';

        imagealphablending( $image, false );
        imagesavealpha( $image, true );
        imagepng($image, $tempFilePath, 6);

        return (new BinaryFileResponse($tempFilePath))
            ->deleteFileAfterSend(true)
            ->setCache(['max_age' => 3600, 'public' => true]);
    }

    private function getBackgroundSetting(string $background): array
    {
        switch ($background) {
            default:
                return [
                    'filename' => 'logo_v1.png',
                    'type' => IMAGETYPE_PNG,
                    'positions' => [
                        0 => ['x' => 65, 'y' => 15],
                        1 => ['x' => 65, 'y' => 35],
                        2 => ['x' => 65, 'y' => 55],
                    ],
                    'color' => ['red' => 100, 'green' => 100, 'blue' => 100],
                    'background' => false,
                    'flip' => false
                ];
        }
    }
}
