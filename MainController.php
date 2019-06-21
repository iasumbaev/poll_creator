<?php


require_once 'PollManager.php';

class MainController
{
    private $pollManager;

    /**
     * MainController constructor.
     * @param $pollManager
     */
    public function __construct($pdo)
    {
        $this->pollManager = new PollManager($pdo);
    }


    function createAction()
    {
        session_start();
        $uri = md5(microtime() . rand());
        if (isset($_SESSION[$uri])) {
            $uri = md5(microtime() . rand());
        }
        $uri = md5(microtime() . rand());
        $_SESSION[$uri] = true;
        require 'view/create.php';
    }

    function pollAction($uri)
    {

        $poll = $this->pollManager->getPollByUri($uri);

        if (is_null($poll)) {
            if (isset($_POST['question']) && isset($_POST['answers'])) {
                $poll = $this->pollManager->createPollFromData($_POST, $uri);
                $this->pollManager->addPollToDataBase($poll);
            } else {
                echo 'Такого опроса не существует!';
                return;

            }
        }

        require 'view/poll.php';

    }


    function getResult($uri)
    {
        $results = $this->pollManager->getResultsByUri($uri);
        $results = json_encode($results);

        echo $results;
    }

    function sendResult()
    {
        if (isset($_POST)) {
            $data = json_decode(file_get_contents("php://input"), true);
            $result = $this->pollManager->createResultFromData($data['poll_id'], $data['answer_id'], $data['name']);
            $this->pollManager->addResultToDataBase($result);

        }
    }

    function setCookies()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        setcookie($data['uri'], true, time() + 60 * 60 * 24 * 365 * 10);
    }


}
