<?php
/**
 * This file is part of the challenge-state project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Challenge\State\Alarm;

use Star\Challenge\State\Door\DoorStateContext;

final class AlarmDisarmed extends AlarmState
{
    /**
     * @return bool
     */
    public function isDisarmed()
    {
        return true;
    }

    public function armAlarm(AlarmStateContext $context)
    {
        $context->setAlarmState(new AlarmArmed());
    }

    public function openDoor(DoorStateContext $context)
    {
    }

    public function closeDoor(DoorStateContext $context)
    {
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
        return 'AlarmDisarmed';
    }
}
