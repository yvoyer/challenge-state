<?php
/**
 * This file is part of the challenge-state project.
 *
 * (c) Yannick Voyer <star.yvoyer@gmail.com> (http://github.com/yvoyer)
 */

namespace Star\Challenge\State;

use Star\Challenge\State\Alarm\AlarmArmed;
use Star\Challenge\State\Alarm\AlarmDisarmed;
use Star\Challenge\State\Alarm\AlarmState;
use Star\Challenge\State\Door\DoorClosed;
use Star\Challenge\State\Door\DoorLocked;
use Star\Challenge\State\Door\DoorOpened;
use Star\Challenge\State\Door\DoorState;
use Star\Challenge\State\Door\DoorUnlocked;

final class HouseStateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var House
     */
    private $context;

    public function setUp()
    {
        $this->context = new House();
    }

    /**
     *  |-----------+--------+----------+------+--------+--------+----------+
     *  | From \ To |  Armed | Disarmed | Open | Closed | Locked | Unlocked |
     *  |-----------+--------+----------+------+--------+--------+----------+
     *  | Armed     |   0    |    1     |   1  |   1    |   1    |    1     |
     *  |-----------+--------+----------+------+--------+--------+----------+
     *  | Disarmed  |   1    |    0     |   1  |   1    |   1    |    1     |
     *  |-----------+--------+----------+------+--------+--------+----------+
     *  | Open      |   1    |    1     |   0  |   1    |   0    |    0     |
     *  |-----------+--------+----------+------+--------+--------+----------+
     *  | Closed    |   1    |    1     |   1  |   0    |   1    |    1     |
     *  |-----------+--------+----------+------+--------+--------+----------+
     *  | Locked    |   1    |    1     |   0  |   0    |   0    |    1     |
     *  |-----------+--------+----------+------+--------+--------+----------+
     *  | Unlocked  |   1    |    1     |   1  |   1    |   1    |    0     |
     *  |-----------+--------+----------+------+--------+--------+----------+
     */

    public function test_door_should_be_locked_by_default()
    {
	    $this->assertDoorIsLocked($this->context);
    }

    public function test_door_should_be_closed_by_default()
    {
	    $this->assertDoorIsClosed($this->context);
    }

    public function test_alarm_should_armed_by_default()
    {
	    $this->assertAlarmIsArmed($this->context);
    }

	public function test_close_the_door_before_disarming_alarm()
	{
		$this->assertHouseIsSecuredForLeaving();

		$this->context->unlockDoor();
		$this->assertDoorIsUnlocked();
		$this->context->openDoor();
		$this->assertDoorIsOpened();
		$this->context->closeDoor();
		$this->assertDoorIsClosed();
		$this->context->disarmAlarm();

        $this->assertHouseIsSecuredForLiving();

        $this->context->lockDoor();
        $this->assertHouseIsSecuredForSleeping();
        $this->context->unlockDoor();

		$this->context->armAlarm();
		$this->assertAlarmIsArmed();
		$this->context->openDoor();
		$this->assertDoorIsOpened();
		$this->context->closeDoor();
		$this->assertDoorIsClosed();
		$this->context->lockDoor();
		$this->assertDoorIsLocked();

        $this->assertHouseIsSecuredForLeaving();
	}

	public function test_leave_the_door_open_before_disarming_alarm()
	{
		$this->assertHouseIsSecuredForLeaving();

		$this->context->unlockDoor();
		$this->context->openDoor();
		$this->context->disarmAlarm();
        $this->context->closeDoor();

		$this->assertHouseIsSecuredForLiving();

        $this->context->openDoor();
		$this->context->armAlarm();
		$this->context->closeDoor();
		$this->context->lockDoor();

        $this->assertHouseIsSecuredForLeaving();
	}

	public function test_lock_the_door_before_disarming_alarm()
	{
		$this->assertHouseIsSecuredForLeaving();

		$this->context->unlockDoor();
		$this->context->openDoor();
		$this->context->closeDoor();
		$this->context->lockDoor();
		$this->context->disarmAlarm();

        $this->assertHouseIsSecuredForSleeping();

        $this->context->unlockDoor();
        $this->assertHouseIsSecuredForLiving();
        $this->context->lockDoor();

		$this->context->armAlarm();
		$this->context->unlockDoor();
		$this->context->openDoor();
		$this->context->closeDoor();
		$this->context->lockDoor();

        $this->assertHouseIsSecuredForLeaving();
	}

	public function test_lock_the_door_after_disarming_alarm()
	{
		$this->assertHouseIsSecuredForLeaving();

        $this->context->unlockDoor();
        $this->context->openDoor();
        $this->context->disarmAlarm();
        $this->context->closeDoor();
        $this->context->lockDoor();

		$this->assertHouseIsSecuredForSleeping();

        $this->context->armAlarm();
        $this->context->unlockDoor();
        $this->context->openDoor();
        $this->context->closeDoor();
        $this->context->lockDoor();
	}

    public function test_it_should_forbid_to_arm_alarm_when_already_armed()
    {
        $this->assertAlarmIsArmed();
        $this->assertTransitionNotAllowed(new AlarmArmed(), new AlarmArmed());
        $this->context->armAlarm();
    }

    public function test_it_should_forbid_to_disarm_when_already_disarmed()
    {
        $this->context->unlockDoor();
        $this->context->openDoor();
        $this->context->disarmAlarm();
        $this->assertAlarmIsDisarmed();

        $this->assertTransitionNotAllowed(new AlarmDisarmed(), new AlarmDisarmed());
        $this->context->disarmAlarm();
    }

    public function test_should_not_allow_to_open_opened_door() {
        $this->context->unlockDoor();
        $this->context->openDoor();
        $this->assertDoorIsOpened();

        $this->assertTransitionNotAllowed(new DoorOpened(), new DoorOpened());
        $this->context->openDoor();
    }

    public function test_should_not_allow_to_lock_opened_door() {
        $this->context->unlockDoor();
        $this->context->openDoor();
        $this->assertDoorIsOpened();

        $this->assertTransitionNotAllowed(new DoorOpened(), new DoorLocked());
        $this->context->lockDoor();
    }

    public function test_should_not_allow_to_unlock_opened_door() {
        $this->context->unlockDoor();
        $this->context->openDoor();
        $this->assertDoorIsOpened();

        $this->assertTransitionNotAllowed(new DoorOpened(), new DoorUnlocked());
        $this->context->unlockDoor();
    }

    public function test_should_not_allow_to_close_closed_door() {
        $this->context->unlockDoor();
        $this->assertDoorIsClosed();

        $this->assertTransitionNotAllowed(new DoorClosed(), new DoorClosed());
        $this->context->closeDoor();
    }

    public function test_should_not_allow_to_open_locked_door() {
        $this->assertDoorIsLocked();

        $this->assertTransitionNotAllowed(new DoorLocked(), new DoorOpened());
        $this->context->openDoor();
    }

    public function test_should_not_allow_to_close_locked_door() {
        $this->assertDoorIsLocked();
        $this->assertDoorIsClosed();

        $this->assertTransitionNotAllowed(new DoorLocked(), new DoorClosed());
        $this->context->closeDoor();
    }

    public function test_should_not_allow_to_lock_locked_door() {
        $this->assertDoorIsLocked();

        $this->assertTransitionNotAllowed(new DoorLocked(), new DoorLocked());
        $this->context->lockDoor();
    }

    public function test_should_not_allow_to_unlock_unlocked_door() {
        $this->context->unlockDoor();
        $this->assertDoorIsUnlocked();

        $this->assertTransitionNotAllowed(new DoorUnlocked(), new DoorUnlocked());
        $this->context->unlockDoor();
    }

	private function assertTransitionNotAllowed(HouseState $from, HouseState $to)
	{
		$this->setExpectedException(
			InvalidTransitionException::class,
			"Invalid transition: {$from->getName()} to {$to->getName()}."
		);
	}

    private function assertAlarmIsArmed() {
        $this->assertTrue($this->context->alarmIsArmed(), 'Alarm should be armed');
        $this->assertFalse($this->context->alarmIsDisarmed(), 'Alarm should be armed');
    }

	private function assertAlarmIsDisarmed() {
		$this->assertTrue($this->context->alarmIsDisarmed(), 'Alarm should be disarmed');
		$this->assertFalse($this->context->alarmIsArmed(), 'Alarm should be disarmed');
	}

	private function assertDoorIsLocked() {
		$this->assertFalse($this->context->doorIsUnlocked(), 'Door should be locked');
		$this->assertTrue($this->context->doorIsLocked(), 'Door should be locked');
	}

	private function assertDoorIsUnlocked() {
		$this->assertTrue($this->context->doorIsUnlocked(), 'Door should be unlocked');
		$this->assertFalse($this->context->doorIsLocked(), 'Door should be unlocked');
	}

	private function assertDoorIsClosed() {
		$this->assertTrue($this->context->doorIsClosed(), 'Door should be closed');
		$this->assertFalse($this->context->doorIsOpen(), 'Door should be closed');
	}

	private function assertDoorIsOpened() {
		$this->assertFalse($this->context->doorIsClosed(), 'Door should be opened');
		$this->assertTrue($this->context->doorIsOpen(), 'Door should be opened');
	}

	private function assertHouseIsSecuredForLeaving() {
		$this->assertDoorIsLocked($this->context);
		$this->assertAlarmIsArmed($this->context);
		$this->assertDoorIsClosed($this->context);
	}

	private function assertHouseIsSecuredForSleeping() {
		$this->assertAlarmIsDisarmed($this->context);
		$this->assertDoorIsLocked($this->context);
		$this->assertDoorIsClosed($this->context);
	}

	private function assertHouseIsSecuredForLiving() {
		$this->assertDoorIsClosed($this->context);
		$this->assertDoorIsUnlocked($this->context);
		$this->assertAlarmIsDisarmed($this->context);
	}
}
