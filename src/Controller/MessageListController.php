<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CmSmsBundle\Controller;

use Endroid\CmSmsBundle\Repository\MessageRepository;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializerBuilder;

final class MessageListController
{
    public function __invoke(MessageRepository $repository): Response
    {
        $messages = $repository->findAll();

        $serializer = SerializerBuilder::create()->build();

        return new Response(
            $serializer->serialize(['messages' => $messages], 'json'),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }
}
