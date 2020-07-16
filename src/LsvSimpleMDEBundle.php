<?php

declare(strict_types=1);

namespace Lsv\SimpleMDEBundle;

use Lsv\SimpleMDEBundle\DependencyInjection\LsvSimpleMDEExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class LsvSimpleMDEBundle extends Bundle
{
    public function getContainerExtension(): LsvSimpleMDEExtension
    {
        return new LsvSimpleMDEExtension();
    }
}
