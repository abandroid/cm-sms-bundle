<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CmSmsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

final class DashboardController
{
    public function __invoke(Environment $twig): Response
    {
        return new Response($twig->render('@EndroidCmSms/Dashboard/index.html.twig'));
    }
}
