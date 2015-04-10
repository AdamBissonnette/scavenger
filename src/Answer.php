<?php
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="answer")
 */
class Answer implements JsonSerializable
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
     * @ManyToOne(targetEntity="Clue", inversedBy="acceptedAnswers")
     * @var nextClue
     **/
    protected $nextClue; //should be a reference to a Clue object

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
        return $this->nextClue;
    }

    public function setNextClue($nextClue)
    {
        $nextClue->addAnswer($this);
        $this->nextClue = $nextClue;
    }

    public function toString()
    {
        return $this->id . ", " . $this->value . ", (" . $this->nextClue->toString() . ")";
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'value'=> $this->value,
            'nextClue'=> $this->nextClue->jsonSerialize()
        );
    }
}
