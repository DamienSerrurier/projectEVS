<?php

require_once '../../models/entities/Reservation.php';

use ProjectEvs\Reservation;
use ProjectEvs\Activity;
use ProjectEvs\Person;

class ReservationTest extends PHPUnit\Framework\TestCase {

    //Test unitaire sur setActivity
    public function testSetActivityInstanceOf() {
        $reservation = new Reservation();
        $activity = new Activity();
        $reservation->setActivity($activity);
        $this->assertInstanceOf(Activity::class, $reservation->getActivity());
    }

    //Test unitaire sur setPerson
    public function testSetPersonInstanceOf() {
        $reservation = new Reservation();
        $person = new Person();
        $reservation->setPerson($person);
        $this->assertInstanceOf(Person::class, $reservation->getPerson());
    }
}