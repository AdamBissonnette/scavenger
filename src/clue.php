<?php
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity @Table(name="clue")
 */
class Clue
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
    protected $clue;

    public function getId()
    {
        return $this->id;
    }

    public function getClue()
    {
        return $this->clue;
    }

    public function setClue($clue)
    {
        $this->clue = $clue;
    }

    /**
     * @OneToMany(targetEntity="Answer", mappedBy="nextClue")
     * @var answers[]
     **/
    protected $answers = null;
    /**
     * @OneToMany(targetEntity="Hint", mappedBy="clue")
     * @var hints[]
     **/
    protected $hints = null;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->hints = new ArrayCollection();
    }

    public function addAnswer($answer)
    {
        $this->answers[] = $answer;
    }

    public function addHint($hint)
    {
        $this->hints[] = $hint;
    }
}