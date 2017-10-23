<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CmSmsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Twig\Environment;

class DashboardController
{
    public function __invoke(Profiler $profiler, Environment $twig): Response
    {
        // Always disable web profiler when using React
        $profiler->disable();

        return new Response($twig->render('@EndroidCmSms/Dashboard/index.html.twig'));
    }
}
