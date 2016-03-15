<?php
/**
 * This file is part of the challenge-state project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Challenge\State\Door;

interface DoorStateContext
{
    /**
     * @param DoorState $state
     *
     * @internal Should be used by state machine
     */
    public function setDoorState(DoorState $state);

    /**
     * @param LockState $state
     *
     * @internal Should be used by state machine
     */
    public function setLockState(LockState $state);
}
