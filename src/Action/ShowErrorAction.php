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

use Symfony\Component\HttpFoundation\JsonResponse;

class ShowErrorAction
{
    public function __invoke(): JsonResponse
    {
        return new JsonResponse([
            'status' => 404,
            'message' => 'Resource not found'
        ]);
    }
}
