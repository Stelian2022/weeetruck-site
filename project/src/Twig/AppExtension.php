<?php

namespace App\Twig;

use Detection\MobileDetect;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Symfony\Component\HttpFoundation\RequestStack;

class AppExtension extends AbstractExtension
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('is_mobile', [$this, 'isMobile']),
        ];
    }

    public function isMobile()
    {
        $request = $this->requestStack->getCurrentRequest();
        $headers = $request->headers->all();
        $userAgent = $headers['User-Agent'][0] ?? null;
        $mobileDetect = new MobileDetect($headers);
        return $mobileDetect->isMobile();
    }
}
