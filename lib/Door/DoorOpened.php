<?php
/**
 * This file is part of the challenge-state project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Challenge\State\Door;

use Star\Challenge\State\Alarm\AlarmStateContext;

final class DoorOpened extends DoorState
{
    /**
     * @return bool
     */
    public function isOpen()
    {
        return true;
    }

    public function armAlarm(AlarmStateContext $context)
    {
    }

    public function disarmAlarm(AlarmStateContext $context)
    {
    }

    public function closeDoor(DoorStateContext $context)
    {
        $context->setDoorState(new DoorClosed());
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'DoorOpened';
    }
}
