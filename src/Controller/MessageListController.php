<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CmSmsBundle\Controller;

use Endroid\CmSms\Bundle\CmSmsBundle\Entity\Message;
use Endroid\CmSms\Bundle\CmSmsBundle\Repository\MessageRepository;
use Endroid\CmSms\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Endroid\CmSms\Message as DomainMessage;
use Endroid\CmSms\Status as DomainStatus;
use JMS\Serializer\SerializerBuilder;

class MessageListController
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
