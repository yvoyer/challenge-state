<?php
/**
 * This file is part of the challenge-state project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Challenge\State\Door;

use Star\Challenge\State\Alarm\AlarmStateContext;

final class DoorUnlocked extends LockState
{
    /**
     * @return bool
     */
    public function isUnlocked()
    {
        return true;
    }

    public function armAlarm(AlarmStateContext $context)
    {
    }

    public function disarmAlarm(AlarmStateContext $context)
    {
    }

    public function openDoor(DoorStateContext $context)
    {
    }

    public function closeDoor(DoorStateContext $context)
    {
    }

    public function lockDoor(DoorStateContext $context)
    {
        $context->setLockState(new DoorLocked());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'DoorUnlocked';
    }
}
