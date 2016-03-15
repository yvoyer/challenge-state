<?php
/**
 * This file is part of the challenge-state project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Challenge\State;

use Star\Challenge\State\Alarm\AlarmArmed;
use Star\Challenge\State\Alarm\AlarmState;
use Star\Challenge\State\Alarm\AlarmStateContext;
use Star\Challenge\State\Door\DoorClosed;
use Star\Challenge\State\Door\DoorLocked;
use Star\Challenge\State\Door\DoorState;
use Star\Challenge\State\Door\DoorStateContext;
use Star\Challenge\State\Door\LockState;

final class House implements AlarmStateContext, DoorStateContext
{
    /**
     * @var AlarmState
     */
    private $alarmState;

    /**
     * @var DoorState
     */
    private $doorState;

    /**
     * @var LockState
     */
    private $lockState;

    public function __construct()
    {
        $this->doorState = new DoorClosed();
        $this->lockState = new DoorLocked();
        $this->alarmState = new AlarmArmed();
    }

    /**
     * @return bool
     */
    public function doorIsOpen()
    {
        return $this->doorState->isOpen();
    }

    /**
     * @return bool
     */
    public function doorIsClosed()
    {
        return $this->doorState->isClosed();
    }

    /**
     * @return bool
     */
    public function alarmIsArmed()
    {
        return $this->alarmState->isArmed();
    }

    /**
     * @return bool
     */
    public function alarmIsDisarmed()
    {
        return $this->alarmState->isDisarmed();
    }

    /**
     * @return bool
     */
    public function doorIsUnlocked()
    {
        return $this->lockState->isUnlocked();
    }

    /**
     * @return bool
     */
    public function doorIsLocked()
    {
        return $this->lockState->isLocked();
    }

    public function openDoor()
    {
        $this->lockState->openDoor($this);
        $this->doorState->openDoor($this);
        $this->alarmState->openDoor($this);
    }

    public function closeDoor()
    {
        $this->lockState->closeDoor($this);
        $this->doorState->closeDoor($this);
        $this->alarmState->closeDoor($this);
    }

    public function armAlarm()
    {
        $this->lockState->armAlarm($this);
        $this->doorState->armAlarm($this);
        $this->alarmState->armAlarm($this);
    }

    public function disarmAlarm()
    {
        $this->lockState->disarmAlarm($this);
        $this->doorState->disarmAlarm($this);
        $this->alarmState->disarmAlarm($this);
    }

    public function lockDoor()
    {
        $this->lockState->lockDoor($this);
        $this->doorState->lockDoor($this);
        $this->alarmState->lockDoor($this);
    }

    public function unlockDoor()
    {
        $this->doorState->unlockDoor($this);
        $this->lockState->unlockDoor($this);
        $this->alarmState->unlockDoor($this);
    }

    /**
     * @param AlarmState $state
     *
     * @internal Should be used by state machine
     */
    public function setAlarmState(AlarmState $state)
    {
        $this->alarmState = $state;
    }

    /**
     * @param DoorState $state
     *
     * @internal Should be used by state machine
     */
    public function setDoorState(DoorState $state)
    {
        $this->doorState = $state;
    }

    /**
     * @param LockState $state
     *
     * @internal Should be used by state machine
     */
    public function setLockState(LockState $state)
    {
        $this->lockState = $state;
    }
}
