<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CmSmsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Endroid\CmSmsBundle\Entity\Message;

final class MessageRepository extends EntityRepository
{
    public function save(Message $message): void
    {
        $this->getEntityManager()->merge($message);
        $this->getEntityManager()->flush();
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): array
    {
        if (is_null($orderBy)) {
            $orderBy = ['dateUpdated' => 'DESC'];
        }

        return parent::findBy($criteria, $orderBy, $limit, $offset);
    }
}
