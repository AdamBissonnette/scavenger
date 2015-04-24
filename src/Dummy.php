<?php
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="dummy")
 */
class Dummy implements JsonSerializable
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     * @var int
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Clue", inversedBy="huntLocations")
     **/
    protected $clue;
    /**
     * @ManyToOne(targetEntity="User", inversedBy="huntUser")
     **/
    protected $user;

    public function getId()
    {
        return $this->id;
    }

    public function getClue()
    {
        return $this->clue;
    }

    public function getClueID()
    {
        $id = -1;

        if ($this->clue != null)
        {
            $id = $this->clue->getId();
        }

        return $id;
    }

    public function setClue($clue)
    {
        $this->clue = $clue;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getUserID()
    {
        $id = -1;

        if ($this->user != null)
        {
            $id = $this->user->getId();
        }

        return $id;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function __toString()
    {
        return strval($this->id);
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'clueid' => $this->getClueID(),
            'userid' => $this->getUserID()
        );
    }
}