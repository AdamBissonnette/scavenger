<?php
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity @Table(name="story")
 */
class Story implements JsonSerializable
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
    protected $description;
    /**
     * @ManyToOne(targetEntity="Clue", inversedBy="trailings")
     **/
    protected $firstClue;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $endMessage = "";

    /**
     * @Column(type="string")
     * @var string
     */
    protected $defaultHint = "";


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

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getFirstClue()
    {
        return $this->firstClue;
    }

    public function setFirstClue($clue)
    {
        $this->firstClue = $clue;
    }

    public function getFirstClueID()
    {
        $id = -1;

        if ($this->firstClue != null)
        {
            $id = $this->firstClue->getId();
        }

        return $id;
    }

    public function getEndMessage()
    {
        return $this->endMessage;
    }

    public function setEndMessage($endMessage)
    {
        $this->endMessage = $endMessage;
    }

    public function getDefaultHint()
    {
        return $this->defaultHint;
    }

    public function setDefaultHint($defaultHint)
    {
        $this->defaultHint = $defaultHint;
    }

    /**
     * @OneToMany(targetEntity="Hunt", mappedBy="story")
     * @var hunts[]
     **/
    protected $hunts = null;

    /**
     * @ManyToMany(targetEntity="Clue")
     * @var clues[]
     */
    protected $clues = null;

    public function __construct()
    {
        $this->hunts = new ArrayCollection();
        $this->clues = new ArrayCollection();
    }

    public function addHunt($hunt)
    {
        $this->hunts[] = $hunt;
    }

    public function addClue($clue)
    {
        $this->clues[] = $clue;
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
            'description'=> $this->description,
            'clueid'=> $this->getFirstClueID(),
            'hint'=>$this->defaultHint,
            'end'=>$this->endMessage
        );
    }
}
