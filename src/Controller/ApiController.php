<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\InvalidHttpBodyData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiController
 * @package App\ApiController
 */
class ApiController extends AbstractController
{
    /**
     * @param Request $request
     * @return mixed
     * @throws InvalidHttpBodyData
     */
    public function getHttpBodyData(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        if (empty($content)) {
            throw  new InvalidHttpBodyData('Invalid request body');
        }

        return $content;
    }
}
