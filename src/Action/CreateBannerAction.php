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

use App\Banner\BannerInterface;
use App\Repository\BannerRepository;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

class CreateBannerAction
{
    private BannerRepository $repository;

    /** @var array<BannerInterface>  */
    private array $banners;

    private string $assets;

    public function __construct(BannerRepository $repository, iterable $banners, string $assets)
    {
        $this->repository = $repository;
        $this->banners = iterator_to_array($banners);
        $this->assets = $assets;
    }

    public function __invoke(string $username, Request $request): BinaryFileResponse
    {
        $locale = $request->query->get('locale', 'en');
        $dataKey = $request->query->get('data', 'default');
        $backgroundKey = $request->query->get('bg', 'logo_v1');

        if (!in_array($locale, ['en', 'de'])) {
            throw new InvalidArgumentException(sprintf('Unknown locale key `%s` provided.', $locale));
        }

        if (!in_array($dataKey, ['default'])) {
            throw new InvalidArgumentException(sprintf('Unknown data key `%s` provided.', $dataKey));
        }

        if (!array_key_exists($backgroundKey, $this->banners)) {
            throw new InvalidArgumentException(sprintf('Unknown background key `%s` provided.', $backgroundKey));
        }

        /** @var BannerInterface $banner */
        $banner = $this->banners[$backgroundKey];

        $backgroundImage = new File($this->assets . $banner->getFilename());

        switch($backgroundImage->getMimeType()) {
            case 'image/png':
                $image = imagecreatefrompng($backgroundImage->getRealPath());
                break;

            case 'image/jpeg':
                $image = imagecreatefromjpeg($backgroundImage->getRealPath());
                break;

            default:
                throw new InvalidArgumentException(sprintf('Unknown image type `%s`', $backgroundImage->getMimeType()));
        }

        $textFont = $this->assets . $banner->getTextFont();
        $textColor = imagecolorallocate(
            $image,
            $banner->getTextColor()['red'],
            $banner->getTextColor()['green'],
            $banner->getTextColor()['blue']
        );
        $textPositions = $banner->getTextPositions();

        $banner->extendBanner($image);

        $index = 0;
        foreach ($this->repository->getData($dataKey) as $text) {
            imagettftext(
                $image,
                $banner->getTextSize(),
                0,
                $textPositions[$index]['x'],
                $textPositions[$index]['y'],
                $textColor,
                $textFont,
                $text
            );

            $index++;
        }

        $tempFilePath = tempnam(sys_get_temp_dir(), 'img') . '.png';

        imagealphablending( $image, false );
        imagesavealpha( $image, true );
        imagepng($image, $tempFilePath, 6);

        return (new BinaryFileResponse($tempFilePath))
            ->deleteFileAfterSend(true)
            ->setCache(['max_age' => 3600, 'public' => true]);
    }
}
