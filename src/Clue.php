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
    /**
     * @Column(type="string")
     * @var string
     */
    protected $fromNumber="";

    /**
     * @ManyToOne(targetEntity="Story", inversedBy="clues")
     **/
    protected $story = null;
    /**
     * @Column(type="integer")    
     * @var string
     */
    protected $state=1;

    public function getId()
    {
        return $this->id;
    }

    public function getStory()
    {
        return $this->story;
    }

    public function setStory($storyIn)
    {
        $this->story = $storyIn;
    }

    public function getStoryID()
    {
        $id = 0;

        if ($this->story != null)
        {
            $id = $this->story->getId();
        }

        return $id;
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
        $escapedValue = str_replace( "?", "[question_mark]", $this->value );
        $convertedValue = mb_convert_encoding($escapedValue, "ASCII");
        $strippedValue = str_replace("?", "�", $convertedValue);
        $restoredValue = str_replace( "[question_mark]", "?", $strippedValue );

        return mb_convert_encoding($restoredValue, "ASCII");
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getFromNumber($fromNumber)
    {
        $this->fromNumber = $fromNumber;
    }

    public function setFromNumber($fromNumber)
    {
        return $this->fromNumber;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
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

    /**
     * @OneToMany(targetEntity="Dummy", mappedBy="clue")
     * @var huntLocations[]
     **/
    protected $huntLocations = null;

    public function __construct()
    {
        $this->huntLocations = new ArrayCollection();
        $this->beginnings = new ArrayCollection();
        $this->trailings = new ArrayCollection();
        $this->answers = new ArrayCollection();
        $this->hints = new ArrayCollection();
    }

    public function addHuntLocation($huntLocation)
    {
        $this->huntLocations[] = $huntLocation;
        $huntLocation->setClue($this);
    }

    public function removeHuntLocation($huntLocation)
    {
        if (!$this->huntLocations->contains($huntLocation)) {
            return;
        }    
        $this->huntLocations->removeElement($huntLocation);
        $huntLocation->setClue(null);
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

    public function getAnswers()
    {
        return $this->answers;
    }

    public function getHints()
    {
        return $this->hints;
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
            'value'=> $this->getValue(),
            'fromNumber'=>$this->fromNumber,
            'answers' => $this->answers->toArray(),
            'trailings' => $this->trailings->toArray(),
            'hints' => $this->hints->toArray(),
            'storyid' => $this->getStoryID()
        );
    }

    public function jsonProfile()
    {
        $values = $this->jsonSerialize();

        return array(
            'id' => array("label" => "ID", "disabled" => true, "type" => "text", "value" => $values["id"]),
            'name'=> array("label" => "Name", "disabled" => false, "type" => "text", "value" => $values["name"]),
            'value'=> array("label" => "Description", "disabled" => false, "type" => "textarea", "value" => $values["value"]),
            'fromNumber'=>array("label" => "From Number", "disabled" => false, "type" => "text", "value" => $values["fromNumber"]),
            // 'answers' => array("label" => "Answers", "disabled" => false, "type" => "list", "value" => $values["answers"])
        );
    }
}
