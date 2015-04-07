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
     * @OneToMany(targetEntity="Answer", mappedBy="nextClueID")
     * @var answers[]
     **/
    protected $answers = null;
    /**
     * @OneToMany(targetEntity="Hint", mappedBy="clueID")
     * @var hints[]
     **/
    protected $hints = null;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->hints = new ArrayCollection();
    }
}