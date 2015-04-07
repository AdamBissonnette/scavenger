<?php
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity @Table(name="hint")
 */
class Hint
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
    protected $value;
    /**
     * @ManyToOne(targetEntity="Clue", inversedBy="hints")
     **/
    protected $clueID; //should be a reference to a Clue object
    /**
     * @Column(type="integer")
     * @var int
     */
    protected $order;
    /**
     * @Column(type="integer")
     * @var int
     */
    protected $usesLifeline;


    public function getId()
    {
        return $this->id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getClueID()
    {
        return $this->clueID;
    }

    public function setClueID($clueID)
    {
        $this->clueID = $clueID;
    }
}