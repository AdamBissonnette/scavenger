<?php
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity @Table(name="hint")
 */
class Hint implements JsonSerializable
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
    protected $clue; //should be a reference to a Clue object
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

    public function getClue()
    {
        return $this->clue;
    }

    public function setClue($clue)
    {
        $clue->addHint($this);
        $this->clue = $clue;
    }

        public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'value'=> $this->value,
            'clue'=> $this->clue->jsonSerialize()
        );
    }
}