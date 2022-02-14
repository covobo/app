<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class AppKernel extends BaseKernel
{
    use MicroKernelTrait;
}
