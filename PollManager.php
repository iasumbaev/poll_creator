<?php

require_once 'models/Poll.php';
require_once 'models/Result.php';

class PollManager
{
    private $pdo;

    /**
     * PollManager constructor.
     * @param $pdo
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    /**
     * @return PDO
     */
    private function getPDO()
    {
        return $this->pdo;
    }

    public function createPollFromData($pollData, $uri)
    {
        $poll = new Poll($uri);
        $poll->setQuestion($pollData['question']);
        $poll->setAnswers($pollData['answers']);
        if (isset($pollData['poll_id']) && isset($pollData['answers_id'])) {
            $poll->setPollID($pollData['poll_id']);
            $poll->setAnswersID($pollData['answers_id']);
        }
        return $poll;
    }

    public function addPollToDataBase(Poll $poll)
    {
        $pdo = $this->getPDO();

        $sql = 'INSERT INTO poll(question, uri) VALUES(:question,:uri)';
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":question", $question, PDO::PARAM_STR);
        $statement->bindParam(":uri", $uri, PDO::PARAM_STR);
        $question = $poll->getQuestion();
        $uri = $poll->getUri();
        $statement->execute();

        $pollID = $pdo->lastInsertId();
        $poll->setPollID($pollID);
        foreach ($poll->getAnswers() as $index => $answer) {
            $statement = $pdo->prepare('INSERT INTO answer(answer, poll_id) VALUES(:answer, :poll_id)');
            $statement->bindParam(":answer", $answer, PDO::PARAM_STR);
            $statement->bindParam(":poll_id", $pollID, PDO::PARAM_INT);
            $statement->execute();
            $answerIDs[] = $pdo->lastInsertId();
        }
        $poll->setAnswersID($answerIDs);

    }

    public function getPollByUri($uri)
    {
        $pdo = $this->getPDO();
        $statement = $pdo->prepare('SELECT * FROM poll WHERE uri=:uri');
        $statement->execute(array('uri' => $uri));
        $pollArray = $statement->fetch(PDO::FETCH_ASSOC);
        $pollID = $pollArray['id'];
        if(!$pollArray) {
            return null;
        }

        $statement = $pdo->prepare('SELECT * FROM answer WHERE poll_id=:poll_id');
        $statement->bindParam(":poll_id", $pollID, PDO::PARAM_STR);
        $statement->execute();

        $answersArray = $statement->fetchAll(PDO::FETCH_ASSOC);

        $pollData['question'] = $pollArray['question'];
        $pollData['poll_id'] = $pollArray['id'];

        foreach ($answersArray as $index => $item) {
            $pollData['answers'][] = $item['answer'];
            $pollData['answers_id'][] = $item['id'];
        }

        $poll = $this->createPollFromData($pollData, $pollArray['uri']);
        return $poll;
    }

    public function createResultFromData($pollID, $answerID, $name)
    {
        $result = new Result();

        $result->setPollID($pollID);
        $result->setAnswerID($answerID);
        $result->setName($name);


        return $result;
    }

    /**
     * @param Result $result
     */
    public function addResultToDataBase($result)
    {
        $pollID= $result->getPollID();
        $answerID = $result->getAnswerID();
        $name = $result->getName();
        $pdo = $this->getPDO();
        $sql = 'INSERT INTO result(poll_id, answer_id, username) VALUES(:poll_id,:answer_id, :username)';
        $statement = $pdo->prepare($sql);
        $statement->bindParam(":poll_id", $pollID, PDO::PARAM_INT);
        $statement->bindParam(":answer_id", $answerID, PDO::PARAM_INT);
        $statement->bindParam(":username", $name, PDO::PARAM_STR);
        $statement->execute();
    }

    public function getResultsByUri($uri)
    {

        $pdo = $this->getPDO();
        $sql =
            'SELECT username, answer
FROM poll JOIN result ON poll.id = result.poll_id 
JOIN answer ON result.answer_id = answer.id
WHERE uri = :uri';

        $statement = $pdo->prepare($sql);
        $statement->bindParam(":uri", $uri, PDO::PARAM_STR);

        $statement->execute();

        $resultsArray = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $resultsArray;

    }
}