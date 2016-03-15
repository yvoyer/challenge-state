<?php
/**
 * This file is part of the challenge-state project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Challenge\State\Alarm;

use Star\Challenge\State\Door\DoorClosed;
use Star\Challenge\State\Door\DoorLocked;
use Star\Challenge\State\Door\DoorOpened;
use Star\Challenge\State\Door\DoorStateContext;
use Star\Challenge\State\Door\DoorUnlocked;
use Star\Challenge\State\HouseState;
use Star\Challenge\State\InvalidTransitionException;

abstract class AlarmState implements HouseState
{
    /**
     * @return bool
     */
    public function isArmed()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isDisarmed()
    {
        return false;
    }

    public function armAlarm(AlarmStateContext $context)
    {
        throw InvalidTransitionException::fromState($this, new AlarmArmed());
    }

    public function disarmAlarm(AlarmStateContext $context)
    {
        throw InvalidTransitionException::fromState($this, new AlarmDisarmed());
    }

    public function openDoor(DoorStateContext $context)
    {
        throw InvalidTransitionException::fromState($this, new DoorOpened());
    }

    public function closeDoor(DoorStateContext $context)
    {
        throw InvalidTransitionException::fromState($this, new DoorClosed());
    }

    public function lockDoor(DoorStateContext $context)
    {
        throw InvalidTransitionException::fromState($this, new DoorLocked());
    }

    public function unlockDoor(DoorStateContext $context)
    {
        throw InvalidTransitionException::fromState($this, new DoorUnlocked());
    }
}
