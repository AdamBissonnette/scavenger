<?php
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity @Table(name="user")
 */
class User implements JsonSerializable
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $email;

    /**
     * @Column(type="string", unique = true)
     * @var string
     */
    protected $phone;

    /**
     * @ManyToOne(targetEntity="Party", inversedBy="hunts")
     * @var party
     */
    protected $party;

    /**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $registrationDate;

    /**
     * @Column(type="integer")    
     * @var string
     */
    protected $state=1;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;
    }

    public function getParty()
    {
        return $this->party;
    }

    public function setParty($partyIn)
    {
        $this->party = $partyIn;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getPartyID()
    {
        $id = -1;

        if ($this->party != null)
        {
            $id = $this->party->getId();
        }

        return $id;
    }

    /**
     * @//ManyToMany(targetEntity="Party", mappedBy="users")
     * @//var parties[]
     */
    //protected $parties = null;

    public function jsonSerialize()
    {
        $party = null;
        if ($this->getParty() != null)
        {
            $party = $this->getParty()->jsonSerialize();
        }

        return array(
            'id' => $this->id,
            'name'=> $this->name,
            'email'=> $this->email,
            'phone'=> $this->phone,
            'date'=> $this->registrationDate->getTimestamp() * 1000,
            'party'=> $party
        );
    }

    public function jsonSerializeShallow()
    {
        return array(
            'id' => $this->id,
            'name'=> $this->name,
            'email'=> $this->email,
            'phone'=> $this->phone,
            'date'=> $this->registrationDate->getTimestamp() * 1000,
            'party'=> $this->getPartyID()
        );
    }
}
