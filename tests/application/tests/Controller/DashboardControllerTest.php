<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CmSmsBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DashboardControllerTest extends WebTestCase
{
    public function testDashboardController()
    {
        $client = static::createClient();
        $client->request('GET', '/cm-sms/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
