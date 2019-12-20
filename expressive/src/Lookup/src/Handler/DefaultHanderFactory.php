<?php

declare(strict_types=1);

namespace Lookup\Handler;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class DefaultHanderFactory
{
    public function __invoke(ContainerInterface $container) : DefaultHander
    {
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;
        return new DefaultHander($template);
    }
}
