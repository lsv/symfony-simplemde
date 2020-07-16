<?php

declare(strict_types=1);

namespace Lsv\SimpleMDEBundleTest;

use Lsv\SimpleMDEBundle\DependencyInjection\LsvSimpleMDEExtension;
use Lsv\SimpleMDEBundle\LsvSimpleMDEBundle;
use PHPUnit\Framework\TestCase;

class LsvSimpleMDEBundleTest extends TestCase
{
    private LsvSimpleMDEBundle $bundle;

    protected function setUp(): void
    {
        $this->bundle = new LsvSimpleMDEBundle();
    }

    /**
     * @test
     */
    public function canGetExtension(): void
    {
        /* @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf(LsvSimpleMDEExtension::class, $this->bundle->getContainerExtension());
    }
}
