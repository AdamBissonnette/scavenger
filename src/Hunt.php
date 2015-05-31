<?php

/**
 * @Entity @Table(name="hunt")
 */
class Hunt implements JsonSerializable
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     * @var int
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Story", inversedBy="hunts")
     * @var story
     **/
    protected $story;
    /**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $start;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $hintsUsed;

    /**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $end;

    /**
     * @OneToOne(targetEntity="Clue")
     * @var currentClue
     */
    protected $currentClue;

    /**
     * @ManyToOne(targetEntity="Party", inversedBy="hunts")
     * @var party
     */
    protected $party;

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

    public function setStory($story)
    {
        $story->addHunt($this);
        $this->story = $story;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setStart($start)
    {
        $this->start = $start;
    }

    public function getEnd()
    {
        return $this->end;
    }

    public function setEnd($end)
    {
        $this->end = $end;
    }

    public function getHintsUsed()
    {
        return $this->hintsUsed;
    }

    public function setHintsUsed($hintsUsedIn)
    {
        $this->hintsUsed = $hintsUsedIn;
    }

    public function getCurrentClue()
    {
        return $this->currentClue;
    }

    public function setCurrentClue($currentClue)
    {
        $this->currentClue = $currentClue;
    }

    public function getParty()
    {
        return $this->party;
    }

    public function setParty($partyIn)
    {
        $this->party = $partyIn;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function jsonSerialize()
    {
        return array(
             'id' => $this->id,
             'story'=> $this->story->jsonSerialize(),
             'start'=> $this->start,
             'end'=> $this->end,
             'clue'=> $this->currentClue->jsonSerialize(),
             'story'=>$this->story->jsonSerialize(),
             'party'=>$this->party->jsonSerialize(),
             'hintsUsed'=>$this->hintsUsed
        );
    }
}
