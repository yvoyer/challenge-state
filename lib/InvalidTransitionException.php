<?php
/**
 * This file is part of the challenge-state project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Challenge\State;

final class InvalidTransitionException extends \Exception
{
    /**
     * @param HouseState $from
     * @param HouseState $to
     *
     * @return InvalidTransitionException
     */
    public static function fromState(HouseState $from, HouseState $to)
    {
        return new self("Invalid transition: {$from->getName()} to {$to->getName()}.");
    }
}
