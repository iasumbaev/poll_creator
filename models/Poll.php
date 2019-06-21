<?php


class Poll
{

    private $question;

    private $pollID;

    private $uri;

    private $answers;

    private $answersID;

    /**
     * Poll constructor.
     * @param $uri
     */
    public function __construct($uri)
    {
        $this->uri = $uri;
    }


    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * @return array
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param array $answers
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;
    }

    /**
     * @return mixed
     */
    public function getPollID()
    {
        return $this->pollID;
    }

    /**
     * @param mixed $pollID
     */
    public function setPollID($pollID)
    {
        $this->pollID = $pollID;
    }



    /**
     * @return array
     */
    public function getAnswersID()
    {
        return $this->answersID;
    }

    /**
     * @param array $answersID
     */
    public function setAnswersID($answersID)
    {
        $this->answersID = $answersID;
    }

}