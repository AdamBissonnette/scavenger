<?php
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity(repositoryClass="ClueRepository") @Table(name="clue")
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
    protected $value;

    public function getId()
    {
        return $this->id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
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

    public function toString()
    {
        return $this->id . ", " . $this->value;
    }
}