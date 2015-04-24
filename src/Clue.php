<?php
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity @Table(name="clue")
 */
class Clue implements JsonSerializable
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
    protected $value;

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

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @ManyToMany(targetEntity="Answer")
     * @var answers[]
     **/
    protected $answers;

    /**
     * @OneToMany(targetEntity="Hint", mappedBy="clue")
     * @var hints[]
     **/
    protected $hints = null;

    /**
     * @OneToMany(targetEntity="Answer", mappedBy="clue")
     * @var trailings[]
     **/
    protected $trailings = null;

    /**
     * @OneToMany(targetEntity="Answer", mappedBy="clue")
     * @var beginnings[]
     **/
    protected $beginnings = null;

    public function __construct()
    {
        $this->beginnings = new ArrayCollection();
        $this->trailings = new ArrayCollection();
        $this->answers = new ArrayCollection();
        $this->hints = new ArrayCollection();
    }

    public function addBeggining($beginning)
    {
        $this->beginnings[] = $beginning;
        $beginning->setFirstClue($this);
    }

    public function removeBeggining($beginning)
    {
        if (!$this->beginnings->contains($beginning)) {
            return;
        }    
        $this->beginnings->removeElement($beginning);
        $beginning->setFirstClue(null);
    }

    public function addTrailing($trailing)
    {
        $this->trailings[] = $trailing;
        $trailing->setClue($this);
        // var_dump(json_encode($this->trailings->toArray()));
        // var_dump(json_encode($trailing));
    }

    public function removeTrailing($trailing)
    {
        if (!$this->trailings->contains($trailing)) {
            return;
        }    
        $this->trailings->removeElement($trailing);
        $trailing->setClue(null);
    }

    public function getTrailings()
    {
        return $this->trailings;
    }

    public function addAnswer($answer)
    {
        $this->answers[] = $answer;
    }

    public function removeAnswer($answer)
    {
        if (!$this->answers->contains($answer)) {
            return;
        }    
        $this->answers->removeElement($answer);
    }

    public function addHint($hint)
    {
        $hint->setClue($this);
        $this->hints[] = $hint;
    }

    public function removeHint($hint)
    {
        if (!$this->hints->contains($hint)) {
            return;
        }    
        $this->hints->removeElement($hint);
        $hint->setClue(null);
    }

    public function __toString()
    {
        return strval($this->id);
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'value'=> $this->value,
            'answers' => $this->answers->toArray(),
            'trailings' => $this->trailings->toArray(),
            'hints' => $this->hints->toArray()
        );
    }

    public function jsonProfile()
    {
        $values = $this->jsonSerialize();

        return array(
            'id' => array("type" => "text", "value" => $values["id"]),
            'name'=> array("type" => "text", "value" => $values["name"]),
            'value'=> array("type" => "textarea", "value" => $values["value"]),
            'answers' => array("type" => "list", "value" => $values["answers"])
        );
    }
}
