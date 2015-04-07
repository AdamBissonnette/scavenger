<?php
/**
 * @Entity @Table(name="log")
 */
class Log
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
    protected $from;
    /**
     * @Column(type="string")
     * @var string
     */
    protected $to;
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
        return $this->from;
    }

    public function setFrom($from)
    {
        $this->from = $from;
    }
    public function getTo()
    {
        return $this->to;
    }

    public function setTo($to)
    {
        $this->to = $to;
    }
    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }
}