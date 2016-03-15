<?php
/**
 * This file is part of the challenge-state project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Challenge\State\Door;

use Star\Challenge\State\Alarm\AlarmStateContext;

final class DoorClosed extends DoorState
{
    /**
     * @return bool
     */
    public function isClosed()
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
        $context->setDoorState(new DoorOpened());
    }

    public function lockDoor(DoorStateContext $context)
    {
    }

    public function unlockDoor(DoorStateContext $context)
    {
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'DoorClosed';
    }
}
