<?php

class NostoUser extends NostoObject implements NostoUserInterface
{
    /**
     * @var string the account owner first name.
     */
    private $firstName;

    /**
     * @var string the account owner last name.
     */
    private $lastName;

    /**
     * @var string the account owner email address.
     */
    private $email;

    /**
     * The first name of the account owner.
     *
     * @return string the first name.
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * The last name of the account owner.
     *
     * @return string the last name.
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * The email address of the account owner.
     *
     * @return string the email address.
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the owner email address.
     *
     * @param string $email the email address.
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
}
