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

    /** Méthode permettant de récupérer l'objet Activity
     * @return Activity l'objet Activity
     */
    public function getActivity() : Activity {
        return $this->activity;
    }

    /** Méthode permettant de définir l'objet Activity
     * @param Activity l'objet Activity
     */
    public function setActivity(Activity $activity) {
        $this->activity = $activity;
    }

    /** Méthode permettant de récupérer l'objet Person
     * @return Person l'objet Person
     */
    public function getPerson() : Person {
        return $this->person;
    }

    /** Méthode permettant de définir l'objet Person
     * @param Person l'objet Person
     */
    public function setPerson(Person $person) {
        $this->person = $person;  
    }

    public function getBooking_date() : string {
        return $this->booking_date;
    }

    public function setBooking_date(string $booking_date) {
        $this->booking_date = $booking_date;
    }

    /** Méthode permettant de récupérer le status de réservation de l'activité
     * @return bool le status de réservation de l'activité
     */
    public function getStatus() : bool {
        return $this->status;
    }

    /** Méthode permettant de définir le status de réservation de l'activité
     * @param bool le status de réservation de l'activité
     */
    public function setStatus(bool $status) {
        $this->status = $status;
    }
    
    /** Méthode permettant de récupérer le nombre de réservation de l'activité
     * @return int Le nombre de réservation de l'activité
     */
    public function getNumber_of_reservation() : int {
        return $this->number_of_reservation;
    }

    /** Méthode permettant de définir le nombre de réservation de l'activité
     * @param int Le nombre de réservation de l'activité
     * @throws ExceptionPerso Si le nombre de réservation est négatif ou non valide
     */
    public function setNumber_of_reservation(int $number_of_reservation) {
        $this->number_of_reservation = $number_of_reservation;
    }
}