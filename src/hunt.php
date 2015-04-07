<?php
/**
 * @Entity @Table(name="hunt")
 */
class Hunt
{
    /**
     * @Id @Column(type="integer") @GeneratedValue
     * @var int
     */
    protected $id;
    /**
     * @ManyToOne(targetEntity="Story", inversedBy="hunts")
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

}