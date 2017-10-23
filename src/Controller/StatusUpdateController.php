<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CmSmsBundle\Controller;

use Endroid\CmSms\Bundle\CmSmsBundle\Entity\Message;
use Endroid\CmSms\Bundle\CmSmsBundle\Entity\Status;
use Endroid\CmSms\Bundle\CmSmsBundle\Exception\InvalidStatusDataException;
use Endroid\CmSms\Bundle\CmSmsBundle\Repository\MessageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Endroid\CmSms\Status as DomainStatus;

class StatusUpdateController
{
    public function __invoke(Request $request, MessageRepository $repository)
    {
        // Support both GET and POST
        $data = $request->getMethod() === Request::METHOD_GET ? $request->query->all() : $request->request->all();

        try {
            $status = DomainStatus::fromWebHookData($data);
        } catch (InvalidStatusDataException $exception) {
            return new Response();
        }

        /** @var Message $message */
        $message = $repository->find($status->getMessageId());

        if (!$message instanceof Message) {
            return new Response();
        }

        $message->addStatus(Status::fromDomain($status));
        $repository->save($message);

        return new Response();
    }
}
