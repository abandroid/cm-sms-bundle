<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CmSmsBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Endroid\CmSms\Message as DomainMessage;
use Endroid\CmSms\StatusCode;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="Endroid\CmSmsBundle\Repository\MessageRepository")
 * @ORM\Table(name="cm_sms_message")
 */
class Message
{
    /**
     * @ORM\Column(type="string")
     * @ORM\Id
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\Column(type="string")
     */
    private $sender;

    /**
     * @ORM\Column(type="array")
     */
    private $recipients;

    /**
     * @ORM\Column(type="array")
     */
    private $options;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Type("DateTime<'Y-m-d H:i'>")
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="datetime")
     * @Serializer\Type("DateTime<'Y-m-d H:i'>")
     */
    private $dateUpdated;

    /**
     * @ORM\Column(type="integer")
     */
    private $statusCode;

    /**
     * @ORM\OneToMany(targetEntity="Endroid\CmSmsBundle\Entity\Status", mappedBy="message", cascade={"persist"})
     */
    private $statuses;

    public function __construct()
    {
        $this->recipients = [];
        $this->options = [];
        $this->statuses = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getSender(): string
    {
        return $this->sender;
    }

    public function getRecipients(): array
    {
        return $this->recipients;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getDateCreated(): DateTime
    {
        return $this->dateCreated;
    }

    public function getDateUpdated(): DateTime
    {
        return $this->dateUpdated;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getStatuses(): array
    {
        return $this->statuses->toArray();
    }

    /**
     * @Serializer\VirtualProperty()
     */
    public function getTranslationKey(): string
    {
        $translationKeys = StatusCode::getTranslationKeys();

        return $translationKeys[$this->statusCode];
    }

    public static function fromDomain(DomainMessage $domainMessage): self
    {
        $message = new static();
        $message->id = $domainMessage->getId();
        $message->body = $domainMessage->getBody();
        $message->sender = $domainMessage->getFrom();
        $message->recipients = $domainMessage->getTo();
        $message->options = $domainMessage->getOptions();
        $message->dateCreated = $domainMessage->getDateCreated();
        $message->dateUpdated = $domainMessage->getDateUpdated();
        $message->statusCode = $domainMessage->getStatusCode();

        return $message;
    }

    public function addStatus(Status $status): void
    {
        $status->setMessage($this);
        $this->statuses->add($status);

        // Never change the resulting status code when a delivery confirmation was sent
        if (StatusCode::DELIVERED == $this->statusCode) {
            return;
        }

        $this->statusCode = $status->getCode();
        $this->dateUpdated = new DateTime();
    }
}
