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
     * @Column(type="string")
     * @var string
     */
    protected $phone;

    /**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $registrationDate;

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

    /**
     * @//ManyToMany(targetEntity="Party", mappedBy="users")
     * @//var parties[]
     */
    //protected $parties = null;

    public function __construct()
    {
        //$this->parties = new ArrayCollection();
    }

        public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'name'=> $this->name,
            'phone'=> $this->phone,
            'registrationDate'=> $this->registrationDate,
        );
    }
}