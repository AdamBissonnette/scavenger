<?php
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity @Table(name="party")
 */
class Party implements JsonSerializable
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

    /**
     * @ManyToMany(targetEntity="User")
     * @var users[]
     */
    protected $users = null;

    /**
     * @ManyToMany(targetEntity="Hunt")
     * @var hunts[]
     */
    protected $hunts = null;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->hunts = new ArrayCollection();
    }

    public function addHunt($hunt)
    {
        $this->hunts[] = $hunt;
    }

    public function addUser($user)
    {
        $this->users[] = $user;
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name
        );
    }
}
