<?php

namespace App;

use App\Core\Factory\DoctrineCacheFactory;
use App\Core\Factory\DoctrineFactory;
use App\Domain\Application\User\UserService;
use App\Domain\Infrastructure\Container\Application\User\UserServiceFactory;
use App\Http\Action\HomeAction;
use App\Http\Action\HomeActionFactory;
use Doctrine\Common\Cache\Cache;
use Doctrine\ORM\EntityManager;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'invokables' => [
                Action\PingAction::class => Action\PingAction::class,
            ],
            'factories'  => [
                Action\HomePageAction::class => Action\HomePageFactory::class,
                Cache::class => DoctrineCacheFactory::class,
                EntityManager::class  => DoctrineFactory::class,
                UserService::class => UserServiceFactory::class,
                HomeAction::class => HomeActionFactory::class
            ],
        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array
     */
    public function getTemplates()
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
