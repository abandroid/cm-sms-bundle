<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CmSmsBundle\Controller;

use Endroid\CmSmsBundle\Entity\Message;
use Endroid\CmSmsBundle\Repository\MessageRepository;
use Endroid\CmSms\Client;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Endroid\CmSms\Message as DomainMessage;

final class MessageSendController
{
    public function __invoke(string $phoneNumber, Client $client, MessageRepository $repository): Response
    {
        $message = new DomainMessage();
        $message->addTo($phoneNumber);
        $message->setBody('Test message');

        /*
         * Make sure the entity is persisted before sending so status
         * updates received between sending and persisting can be linked.
         */
        $messageEntity = Message::createFromDomain($message);
        $repository->save($messageEntity);

        /*
         * When sending the message its properties are altered: defaults
         * are set and the sent status is set upon success.
         */
        $client->sendMessage($message);

        /*
         * Update the stored message so it reflects the domain message.
         */
        $messageEntity->updateFromDomain($message);
        $repository->save($messageEntity);

        return new JsonResponse($message);
    }
}
