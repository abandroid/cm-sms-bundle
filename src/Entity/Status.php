<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CmSmsBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Endroid\CmSms\Status as DomainStatus;

/**
 * @ORM\Entity
 * @ORM\Table(name="cm_sms_status")
 */
class Status
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Id
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="integer")
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="Endroid\CmSmsBundle\Entity\Message", inversedBy="statuses", cascade={"persist"})
     */
    private $message;

    /**
     * @ORM\Column(type="array")
     */
    private $webHookData;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function setMessage(Message $message): void
    {
        $this->message = $message;
    }

    public function getWebHookData(): array
    {
        return $this->getWebHookData();
    }

    public static function fromDomain(DomainStatus $domainStatus): self
    {
        $status = new static();
        $status->dateCreated = $domainStatus->getDateCreated();
        $status->code = $domainStatus->getCode();
        $status->webHookData = $domainStatus->getWebHookData();

        return $status;
    }
}
