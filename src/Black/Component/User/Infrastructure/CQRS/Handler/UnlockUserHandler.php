<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Component\User\Infrastructure\CQRS\Handler;

use Black\Component\User\Domain\Event\UserUnlockedEvent;
use Black\Component\User\Infrastructure\CQRS\Command\UnlockUserCommand;
use Black\Component\User\Infrastructure\Doctrine\UserManager;
use Black\Component\User\Infrastructure\Service\UserStatusService;
use Black\Component\User\UserDomainEvents;
use Black\DDD\CQRSinPHP\Infrastructure\CQRS\CommandHandler;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class UnlockUserHandler
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
class UnlockUserHandler implements CommandHandler
{
    /**
     * @var UserManager
     */
    protected $manager;

    /**
     * @var UserStatusService
     */
    protected $service;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @param UserManager $manager
     * @param UserStatusService $service
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        UserManager $manager,
        UserStatusService $service,
        EventDispatcherInterface $dispatcher
    ) {
        $this->manager    = $manager;
        $this->service    = $service;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param UnlockUserCommand $command
     */
    public function handle(UnlockUserCommand $command)
    {
        $user = $this->service->unlock($command->getUserId());

        if ($user) {
            $this->manager->flush();

            $event = new UserUnlockedEvent($user);
            $this->dispatcher->dispatch(UserDomainEvents::USER_DOMAIN_UNLOCKED, $event);
        }
    }
}
