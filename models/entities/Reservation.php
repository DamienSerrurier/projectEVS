<?php

namespace ProjectEvs;

class Reservation {

    //Propriétés
    private Activity $activity;
    private Person $person;
    private string $booking_date;
    private bool $status;
    private int $number_of_reservation;

    //Constructeur

    //Getters et Setters
    public function getActivity() : Activity {
        return $this->activity;
    }

    public function setActivity(Activity $activity) {

        if ($activity instanceof Activity) {
            return $this->activity = $activity;
        }
        else {
            throw new ExceptionPerso("Ceci n'est pas une instance de la classe Activity");
        }
    }

    public function getPerson() : Person {
        return $this->person;
    }

    public function setPerson(Person $person) {

        if ($person instanceof Person) {
            return $this->person = $person;
        }
        else {
            throw new ExceptionPerso("Ceci n'est pas une instance de la classe Person");
        }
    }

    public function getBooking_date() : string {
        return $this->booking_date;
    }

    public function setBooking_date(string $booking_date) {
        $this->booking_date = $booking_date;
    }

    public function getStatus() : bool {
        return $this->status;
    }

    public function setStatus(bool $status) {
        $this->status = $status;
    }
    
    public function getNumber_of_reservation() : int {
        return $this->number_of_reservation;
    }

    public function setNumber_of_reservation(int $number_of_reservation) {
        $this->number_of_reservation = $number_of_reservation;
    }
}