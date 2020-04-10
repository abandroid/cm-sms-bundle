<?php

declare(strict_types=1);

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Endroid\CmSmsBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpKernel\Profiler\Profiler;
use Twig\Environment;

final class DashboardController
{
    private $kernel;
    private $templating;

    public function __construct(KernelInterface $kernel, Environment $templating)
    {
        $this->kernel = $kernel;
        $this->templating = $templating;
    }

    public function __invoke(): Response
    {
        // Disable profiler because it conflicts with Vue
        if ($this->kernel->getContainer()->has('profiler')) {
            /** @var Profiler $profiler */
            $profiler = $this->kernel->getContainer()->get('profiler');
            $profiler->disable();
        }

        return new Response($this->templating->render('@EndroidCmSms/dashboard.html.twig'));
    }
}
