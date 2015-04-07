<?php
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity @Table(name="answer")
 */
class Answer
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
     * @ManyToOne(targetEntity="Clue", inversedBy="answers")
     **/
    protected $nextClueID; //should be a reference to a Clue object

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

    public function getNextClue()
    {
        return $this->nextClueID;
    }

    public function setNextClue($nextClueID)
    {
        $this->nextClueID = $nextClueID;
    }
}