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
        return $this->id . ", " . $this->name . ", " . $this->description;
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'description'=> $this->description,
        );
    }
}
