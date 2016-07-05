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
    protected $toNumber="";
    /**
     * @ManyToOne(targetEntity="Clue", inversedBy="trailings")
     **/
    protected $clue;
    /**
     * @ManyToOne(targetEntity="Story", inversedBy="answers")
     **/
    protected $story=null;
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

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getTo()
    {
        return $this->toNumber;
    }

    public function setTo($toNumber)
    {
        $this->toNumber = $toNumber;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
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

    public function getStory()
    {
        return $this->story;
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

    public function setStory($story)
    {
        $this->story = $story;
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
            'to'=> $this->toNumber,
            'clueid' => $this->getClueID(),
            'storyid' => $this->getStoryID()
        );
    }

    public function jsonProfile()
    {
        return array(
            'id' => array("type" => "text", "value" => $this->id),
            'name' => array("type" => "text", "value" => $this->name),
            'value'=> array("type" => "textarea", "value" => $this->value),
            'to'=> array("type" => "text", "value" => $this->toNumber),
            'clueid' => array("type" => "select", "value" => $this->getClueID(),
             "data" => array("fn" => "gclues", "format" => "{{item.id}} | {{item.name}}")
             )
        );
    }
}
