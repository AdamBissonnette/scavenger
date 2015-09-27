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
     * @Column(type="datetime", nullable=true)
     * @var DateTime
     */
    protected $start;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $hintsUsed;

    /**
     * @Column(type="datetime", nullable=true)
     * @var DateTime
     */
    protected $end;

    /**
     * @Column(type="string")    
     * @var string
     */
    protected $code = "";

    /**
     * @ManyToOne(targetEntity="Clue")
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

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getClueID()
    {
        $id = -1;

        if ($this->currentClue != null)
        {
            $id = $this->currentClue->getId();
        }

        return $id;
    }

    public function getPartyID()
    {
        $id = -1;

        if ($this->party != null)
        {
            $id = $this->party->getId();
        }

        return $id;
    }

    public function getStoryID()
    {
        $id = -1;

        if ($this->story != null)
        {
            $id = $this->story->getId();
        }

        return $id;
    }

    public function jsonSerialize()
    {
        return array(
             'id' => $this->id,
             'story'=> $this->getStoryID(),
             'start'=> $this->start,
             'end'=> $this->end,
             'code'=> $this->code,
             'clue'=> $this->getClueID(),
             'party'=>$this->getPartyID(),
             'hintsUsed'=>$this->hintsUsed
        );
    }

    //Borrowed from http://php.net/manual/en/function.mt-rand.php#112889
    public static function GenerateCode ($l, $c = 'abcdefghijklmnopqrstuvwxyz1234567890') {
        for ($s = '', $cl = strlen($c)-1, $i = 0; $i < $l; $s .= $c[mt_rand(0, $cl)], ++$i);
        return $s;
    }
}
