<?php


class Result
{
    private $pollID;
    private $answerID;
    private $name;

    /**
     * @return int
     */
    public function getPollID()
    {
        return $this->pollID;
    }

    /**
     * @param int $pollID
     */
    public function setPollID($pollID)
    {
        $this->pollID = $pollID;
    }

    /**
     * @return int
     */
    public function getAnswerID()
    {
        return $this->answerID;
    }

    /**
     * @param int $answerID
     */
    public function setAnswerID($answerID)
    {
        $this->answerID = $answerID;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }



}