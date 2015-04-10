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
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $end;

    /**
     * @OneToOne(targetEntity="Clue")
     * @var currentClue
     */
    protected $currentClue;

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

    public function getCurrentClue()
    {
        return $this->currentClue;
    }

    public function setCurrentClue($currentClue)
    {
        $this->currentClue = $currentClue;
    }

    public function jsonSerialize()
    {
        return array(
             'id' => $this->id,
             'story'=> $this->story->jsonSerialize(),
             'start'=> $this->start,
             'end'=> $this->end,
             'currentClue'=> $this->currentClue->jsonSerialize()
        );
    }
}
