<?php

interface NostoUserInterface
{
    /**
     * The first name of the user
     *
     * @return string the first name.
     */
    public function getFirstName();

    /**
     * The last name of the user
     *
     * @return string the last name.
     */
    public function getLastName();

    /**
     * The email address of the user
     *
     * @return string the email address.
     */
    public function getEmail();
}
