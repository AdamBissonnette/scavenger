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

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'to'=> $this->toNumber,
            'from'=> $this->fromNumber,
            'value'=> $this->value,
            'date'=> $this->date,
        );
    }
}
