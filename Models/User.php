<?php


class User implements JsonSerializable
{
    // declare required fields
    private $userID, $firstName, $lastName, $email, $username, $password, $profilePicture, $latitude, $longitude;

    /**
     * User constructor.
     * @param $userID
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $username
     * @param $password
     * @param $profilePicture
     */
    public function __construct($dbRow)
    {
        $this->userID = $dbRow['userID'];
        $this->firstName = $dbRow['first_name'];
        $this->lastName = $dbRow['last_name'];
        $this->email = $dbRow['email'];
        $this->username = $dbRow['username'];
        $this->password = $dbRow['password'];
        $this->profilePicture = $dbRow['profile_picture'];
        $this->latitude = $dbRow['latitude'];
        $this->longitude = $dbRow['longitude'];
    }

    /**
     * @return user ID
     */
    public function getUserID()
    {
        return $this->userID;
    }

    /**
     * @return firstname
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return lastname
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @return email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return profilePicture
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * @return latitude
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return longitude
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    //JavaScript containing JSON syntax
    public function jsonSerialize()
    {
        return [
            'userID' => $this->userID,
            'username' => $this->username,
            'name' => $this->firstName . " " . $this->lastName,
            'profilePicture' => $this->profilePicture,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,

        ];
    }
}