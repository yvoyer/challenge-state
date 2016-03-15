<?php
/**
 * This file is part of the challenge-state project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Challenge\State\Alarm;

interface AlarmStateContext
{
    /**
     * @param AlarmState $state
     *
     * @internal Should be used by state machine
     */
    public function setAlarmState(AlarmState $state);
}
