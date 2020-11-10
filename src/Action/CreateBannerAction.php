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

    public function __invoke(string $username, string $variant, Request $request): BinaryFileResponse
    {
        if (!array_key_exists($variant, $this->banners)) {
            throw new InvalidArgumentException(sprintf('Unknown variant key `%s` provided.', $variant));
        }

        /** @var BannerInterface $banner */
        $banner = $this->banners[$variant];

        $image = $banner->create($this->repository->getData($username), $this->assets);
        $tempFilePath = tempnam(sys_get_temp_dir(), 'img') . '.png';

        imagealphablending( $image, false );
        imagesavealpha( $image, true );
        imagepng($image, $tempFilePath, 6);

        return (new BinaryFileResponse($tempFilePath))
            ->deleteFileAfterSend(true)
            ->setCache(['max_age' => 3600, 'public' => true]);
    }
}
