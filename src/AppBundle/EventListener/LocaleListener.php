<?php

namespace AppBundle\EventListener;

use Symfony\Component\{
    EventDispatcher\EventSubscriberInterface,
    HttpKernel\Event\GetResponseEvent,
    HttpKernel\KernelEvents
};

class LocaleListener implements EventSubscriberInterface
{
    private $defaultLocaleLanguage;

    public function __construct($defaultLocaleLanguage = 'pl_PL')
    {
        $this->defaultLocaleLanguage = $defaultLocaleLanguage;
    }

    public function onKernelRequest(GetResponseEvent $event): void
    {
        $request = $event->getRequest();
        if (!$request->hasPreviousSession()) {
            return;
        }

        if ($locale = $request->attributes->get('_locale')) {
            $request->getSession()->set('_locale', $locale);
        } else {
            $request->setLocale($request->getSession()->get('_locale', $this->defaultLocaleLanguage));
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                ['onKernelRequest', 10]
            ],
        ];
    }
}