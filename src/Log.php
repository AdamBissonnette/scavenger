<?php

/**
 * @Entity @Table(name="log")
 */
class Log implements JsonSerializable
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
    protected $fromNumber;
    /**
     * @Column(type="string")
     * @var string
     */
    protected $toNumber;
    /**
     * @Column(type="string")
     * @var string
     */
    protected $value;
    /**
     * @Column(type="datetime")
     * @var DateTime
     */
    protected $date;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $direction = 1; //Incoming / Outgoing

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $type = 1; // clue, answer, hint, global ...

    /**
     * @ManyToOne(targetEntity="User")
     **/
    protected $user;

    /**
     * @ManyToOne(targetEntity="Hunt")
     **/
    protected $hunt;

    /**
     * @ManyToOne(targetEntity="Clue")
     **/
    protected $clue = null;

    /**
     * @ManyToOne(targetEntity="Answer")
     **/
    protected $answer = null;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $data = "";

    /**
     * @Column(type="integer")    
     * @var string
     */
    protected $state=1;

    public function getId()
    {
        return $this->id;
    }

    public function getFrom()
    {
        return $this->fromNumber;
    }

    public function setFrom($fromIn)
    {
        $this->fromNumber = $fromIn;
    }
    public function getTo()
    {
        return $this->toNumber;
    }

    public function setTo($toIn)
    {
        $this->toNumber = $toIn;
    }
    public function getValue()
    {
        return $this->value;
    }

    public function setValue($valueIn)
    {
        $this->value = $valueIn;
    }
    public function getDate()
    {
        return $this->date;
    }

    public function setDate($dateIn)
    {
        $this->date = $dateIn;
    }

    public function getDirection()
    {
        return $this->direction;
    }

    public function setDirection($directionIn)
    {
        $this->direction = $directionIn;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($typeIn)
    {
        $this->type = $typeIn;
    }

    public function getClue()
    {
        return $this->clue;
    }

    public function getClueID()
    {
        $id = -1;

        if ($this->clue != null)
        {
            $id = $this->clue->getId();
        }

        return $id;
    }

    public function setClue($clue)
    {
        $this->clue = $clue;
    }

    public function getAnswer()
    {
        return $this->answer;
    }

    public function getAnswerID()
    {
        $id = -1;

        if ($this->answer != null)
        {
            $id = $this->answer->getId();
        }

        return $id;
    }

    public function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    public function getHunt()
    {
        return $this->hunt;
    }

    public function setHunt($huntIn)
    {
        $this->hunt = $huntIn;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($userIn)
    {
        $this->user = $userIn;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($dataIn)
    {
        $this->data = $dataIn;
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
            'to'=> $this->toNumber,
            'from'=> $this->fromNumber,
            'value'=> $this->value,
            'clueid' => $this->getClueID(),
            'answerid' => $this->getAnswerID(),
            'date'=> $this->date->getTimestamp() * 1000,
            'direction'=>$this->direction,
            'type' => $this->type,
            'data' => $this->data
        );
    }
}
