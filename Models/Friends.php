<?php

require_once ('Models/User.php');
class Friends extends User
{
    private $friendID, $friend1, $friend2;

    /**
     * Friend constructor.
     * @param $friendID
     * @param $friend1
     * @param $friend2
     *
     */
    public function __construct($dbRow){
        parent::__construct($dbRow);
        $this->friendID = $dbRow['friendID'];
        $this->friend1 = $dbRow['friend1'];
        $this->friend2 = $dbRow['friend2'];
    }


//    return the friend id
    public function getFriendID()
    {
        return $this->friendID;
    }

    //return the friend 1
    public function getFriend1()
    {
        return $this->friend1;
    }

    public function getFriend2(){
        return $this->friend2;
    }




}