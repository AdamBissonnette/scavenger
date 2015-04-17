<?php
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity(repositoryClass="ClueRepository") @Table(name="clue")
 */
class Clue implements JsonSerializable
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

    /**
     * @OneToMany(targetEntity="Answer", mappedBy="nextClue")
     * @var acceptedAnswers[]
     **/
    protected $acceptedAnswers = null;

    /**
     * @ManyToMany(targetEntity="Answer")
     * @var answers[]
     **/
    protected $answers;

    /**
     * @OneToMany(targetEntity="Hint", mappedBy="clue")
     * @var hints[]
     **/
    protected $hints = null;

    public function __construct()
    {
        $this->acceptedAnswers = new ArrayCollection();
        $this->answers = new ArrayCollection();
        $this->hints = new ArrayCollection();
    }

    public function addAcceptedAnswer($acceptedAnswer)
    {
        $this->acceptedAnswers[] = $acceptedAnswer;
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

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'value'=> $this->value,
        );
    }
}
