<?php
/**
 * This file is part of the challenge-state project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Challenge\State\Door;

use Star\Challenge\State\Alarm\AlarmStateContext;

final class DoorLocked extends LockState
{
    /**
     * @return bool
     */
    public function isLocked()
    {
        return true;
    }

    public function armAlarm(AlarmStateContext $context)
    {
    }

    public function disarmAlarm(AlarmStateContext $context)
    {
    }

    public function unlockDoor(DoorStateContext $context)
    {
        $context->setLockState(new DoorUnlocked());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'DoorLocked';
    }
}
