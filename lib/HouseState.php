<?php
/**
 * This file is part of the challenge-state project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Challenge\State;

use Star\Challenge\State\Alarm\AlarmStateContext;
use Star\Challenge\State\Door\DoorStateContext;

interface HouseState
{
    /**
     * @return string
     */
    public function getName();

    // Transitions
    public function armAlarm(AlarmStateContext $context);
    public function disarmAlarm(AlarmStateContext $context);
    public function openDoor(DoorStateContext $context);
    public function closeDoor(DoorStateContext $context);
    public function lockDoor(DoorStateContext $context);
    public function unlockDoor(DoorStateContext $context);
}
