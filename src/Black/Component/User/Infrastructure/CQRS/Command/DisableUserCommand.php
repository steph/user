<?php

/*
 * This file is part of the Black package.
 *
 * (c) Alexandre Balmes <alexandre@lablackroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Black\Component\User\Infrastructure\CQRS\Command;

use Black\Component\User\Domain\Model\UserId;
use Black\DDD\CQRSinPHP\Infrastructure\CQRS\Command;

/**
 * Class DisableUserCommand
 *
 * @author  Alexandre 'pocky' Balmes <alexandre@lablackroom.com>
 * @license http://opensource.org/licenses/mit-license.php MIT
 */
final class DisableUserCommand implements Command
{
    /**
     * @var UserId
     */
    protected $userId;

    /**
     * @param UserId $userId
     */
    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return UserId
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
