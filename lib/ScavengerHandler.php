<?php
require_once('bootstrap.php');

class ScavengerHandler
{
    /* Request Params
    ToCountry
    MediaContentType0
    ToState
    SmsMessageSid
    NumMedia
    ToCity
    FromZip
    SmsSid
    FromState
    SmsStatus
    FromCity
    Body
    FromCountry
    To
    ToZip
    MessageSid
    AccountSid
    From
    MediaUrl0
    ApiVersion
    */
    var $entityManager = null;
    var $message = null;
    var $globals = array('authGlobals' => array(
                            array("regex" => "/(.*)/i", "smsresponse" => "In order to start your adventure you must text \"Start\".")
                            ),
                        'noAuthGlobals' => array(
                            array('regex' => "/.*/", "smsresponse" => "You don't appear the be registered.")
                            )
                     );

    var $user = null;
    var $party = null;
    var $hunt = null;
    var $clue = null;
    var $prevClue = null;
    var $answer = null;
    var $story = null;

    function __construct($incomingMessage, $em)
    {
        $this->message = $incomingMessage;
        $this->entityManager = $em;
    }

    public function CreateResponse()
    {
        $incoming_message_type = LogTypes::TYPE_UNKNOWN;
        $outgoing_message_type = LogTypes::TYPE_UNKNOWN;

        $response_body = "<Response/>";
        $body = $this->message["Body"];
        $fromPhone = $this->message["From"];

        $response_to = array();

        $this->user = FindUserByFrom($fromPhone, $this->entityManager);

        if (isset($this->user))
        {
            $this->party = $this->user->getParty();
        }

        //check to make sure that they are a valid sender
        if (isset($this->party))
        {
            //Get the clue that that user is on
            $this->hunt = ScavengerHandler::FindHuntByParty($this->party, $this->entityManager);

            if (isset($this->hunt))
            {
                $this->prevClue = $this->clue;
                $this->clue = $this->hunt->getCurrentClue();
            }

            if (isset($this->clue))
            {
                //Check for global commands then the correct answer

                //Check if they sent a correct Answer
                // $global_result = $this->_checkGlobals($body, true, true, $this->clue);
                $responseFound = false;

                if (preg_match("/^clue/i", trim($body)))
                {
                    $responseFound = true;
                    $response_body = $this->replace_variables($this->clue->getValue());
                }
                elseif (preg_match("/^hint/i", trim($body)))
                {
                    $responseFound = true;
                    $hintFound = false;

                    $outgoing_message_type = LogTypes::TYPE_HINT;
                    $hint = ScavengerHandler::FindHintsForClue($this->clue, $this->hunt, $this->entityManager);

                    if ($hint != null)
                    {
                        $response_body = $hint->getValue();
                    }
                    else
                    {
                        $response_body = ScavengerHandler::GetDefaultHint(1, $this->entityManager);;
                    }
                }
                elseif (preg_match("/^restart/i", trim($body))) {
                    $responseFound = true;
                    // $this->clue = null;
                    $this->clue = ScavengerHandler::GetFirstClue(1, $this->entityManager);
                    $response_body = $this->clue->getValue();
                    $this->hunt->setCurrentClue($this->clue);
                    $this->entityManager->flush();
                }
                elseif (preg_match("/^quit\s?party/i", trim($body))) {
                    $this->user->setParty(null);
                    $this->entityManager->flush();
                }

                if (!$responseFound)
                {
                    $this->answer = ScavengerHandler::FindAnswerForClueByValue($this->clue, $this->message, $this->entityManager); //clue, sms, mms
                    $incoming_message_type = LogTypes::TYPE_ANSWER;

                    if (isset($this->answer))
                    {
                        //Get the next clue from the answer and format that as a 
                        $nextClue = $this->answer->getClue();

                        if (isset($nextClue))
                        {
                            //Send the next clue
                            //Update the currentClue
                            $response_body = $this->replace_variables($nextClue->getValue());
                            $this->hunt->setCurrentClue($nextClue);
                            $this->entityManager->flush();
                            $outgoing_message_type = LogTypes::TYPE_CLUE;
                        }
                        else
                        {
                            $response_body = ScavengerHandler::GetEndMessage(1, $this->entityManager);;
                            //$this->hunt->setCurrentClue(null);
                            $this->entityManager->flush();
                            $outgoing_message_type = LogTypes::TYPE_END;
                        }
                    }
                    else
                    {
                        //They got the answer wrong - send them a hint
                        //If we don't have hints then suggest that they skip the question and message Adam / Berkley that shits going down

                        $hintFound = false;

                        $outgoing_message_type = LogTypes::TYPE_HINT;
                        $hint = ScavengerHandler::FindHintsForClue($this->clue, $this->hunt, $this->entityManager);

                        if ($hint != null)
                        {
                            $response_body = $hint->getValue();
                        }
                        else
                        {
                            $response_body = ScavengerHandler::GetDefaultHint(1, $this->entityManager);;
                        }
                    }
                }
                else
                {
                    $incoming_message_type = LogTypes::TYPE_GLOBAL;
                    $outgoing_message_type = LogTypes::TYPE_GLOBAL;
                }
            }
            else
            {
                $incoming_message_type = LogTypes::TYPE_GLOBAL;
                $outgoing_message_type = LogTypes::TYPE_GLOBAL;
                $responseFound = false;

                if (preg_match("/^quit\s?party/i", trim($body))) {
                    $this->user->setParty(null);
                    $this->entityManager->flush();
                }
                else
                {
                    if (preg_match("/^start$/i", trim($body)))
                    {
                        //Send first clue
                        $responseFound = true;
                        $this->clue = ScavengerHandler::GetFirstClue(1, $this->entityManager);
                        $response_body = $this->clue->getValue();
                        $this->hunt->setCurrentClue($this->clue);
                        $this->entityManager->flush();
                        $incoming_message_type = LogTypes::TYPE_START;
                        $outgoing_message_type = LogTypes::TYPE_START;
                    }

                    if (!$responseFound)
                    {
                        $response_body = $this->_checkGlobals($body, true);
                    }
                }
            }
        }
        else
        {
            $incoming_message_type = LogTypes::TYPE_GLOBAL;
            $outgoing_message_type = LogTypes::TYPE_GLOBAL;

            //Do global commands for unregistered users
            $response_body = $this->_checkGlobals($body);
        }

        //Log Incoming Message
        $data = array('from' => $this->message["From"], 'to' => $this->message["To"], 'value' => $this->message["Body"], 'data' => json_encode($this->message), 'direction' => LogTypes::DIRECTION_INCOMING, 'type' => $incoming_message_type);
        LogMessage($data, $this->entityManager, $this->user, $this->hunt, $this->prevClue, $this->answer);

        //Log Outgoing Message
        $data = array('from' => $this->message["To"], 'to' => $this->message["From"], 'value' => $response_body, 'data' => format_TwiML($response_body), 'direction' => LogTypes::DIRECTION_OUTGOING, 'type' => $outgoing_message_type);

        LogMessage($data, $this->entityManager, $this->user, $this->hunt, $this->clue);

        if ($this->party != null)
        {
            foreach ($this->party->getUsers() as $user) {
                if ($user->getState() == 1)
                {
                    $response_to[] .= $user->getPhone();
                }
            }
        }
        else
        {
            $response_to[] .= $this->message["From"];
        }

        $response = array("body" => $response_body, "recipients" => $response_to);

        return $response;
    }

    function _checkGlobals($body, $isAuthenticated=false, $hasStarted=false, $curClue=null)
    {
        $responseToGlobal = "";

        $codes = null;
        if (preg_match("/^join ?(.+)$/i", trim($body), $codes))
        {
            $story = ScavengerHandler::FindStoryByCode($codes[1], $this->entityManager);

            if (isset($story))
            {
                $hunt = $this->AddHuntToStory($story);

                if ($story->getType() == 1)
                {
                    $this->clue = $story->GetFirstClue(); //Return first clue of story
                    $hunt->setCurrentClue($this->clue);
                    $this->hunt = $hunt;
                    $this->AddUserToHunt($hunt);

                    return $this->clue->getValue();
                }
                else
                {
                    $this->hunt = $hunt;
                    return $this->AddUserToHunt($hunt);
                }
            }
            else
            {
                $hunt = ScavengerHandler::FindHuntByCode($codes[1], $this->entityManager);

                if (isset($hunt))
                {
                    $this->hunt = $hunt;
                    return $this->AddUserToHunt($hunt);
                }

                return "We don't seem to have that code on file.";
            }

        }

        if ($isAuthenticated)
        {
            foreach ($this->globals["authGlobals"] as $command) {
                if (preg_match($command["regex"], $body))
                {
                    return $command["smsresponse"];
                }
            }
        }
        else
        {
            foreach ($this->globals["noAuthGlobals"] as $command) {
                if (preg_match($command["regex"], $body))
                {
                    return $command["smsresponse"];
                }
            }
        }

        return $responseToGlobal;
    }

    static function FindCurrentClueByUser($user, $entityManager)
    {
        $repository = $entityManager->getRepository("Dummy");

        $dummy = $repository->findOneBy(array('user' => $user->getId()));

        return $dummy;
    }

    static function FindHuntByParty($party, $entityManager)
    {
        $repository = $entityManager->getRepository("Hunt");

        $hunt = $repository->findOneBy(array('party' => $party, 'end' => null));

        return $hunt;
    }

    static function FindAnswerForClueByValue($clue, $message=null)
    {
        $curAnswer = null;

        if (!empty($message["Body"]) || $message["NumMedia"] >= 1)
        {
            $acceptableAnswers = $clue->getAnswers();

            foreach ($acceptableAnswers as $answer) {
                if ($answer->getValue() == "/media/")
                {
                    if ($message["NumMedia"] >= 1)
                    {
                        $curAnswer = $answer;
                        break;
                    }
                }
                else if (preg_match($answer->getValue(), trim($message["Body"]) )) {
                    $curAnswer = $answer;
                    break;
                }

            }
        }
        return $curAnswer;
    }

    static function GetFirstClue($storyID=1, $entityManager)
    {
        $story = $entityManager->find("Story", $storyID);

        return $story->getFirstClue();
    }

    static function GetDefaultHint($storyID=1, $entityManager)
    {
        $story = $entityManager->find("Story", $storyID);

        return $story->getDefaultHint();        
    }

    static function GetEndMessage($storyID=1, $entityManager)
    {
        $story = $entityManager->find("Story", $storyID);

        return $story->getEndMessage();        
    }

    static function FindHintsForClue($curClue, $curHunt, $entityManager)
    {
        $curHint = null;

        $repository = $entityManager->getRepository("Hint");
        $searchParams = array('clue' => $curClue->getId(),
                                           'state' => 1);
        $orderParams = array('priority' => 'ASC');
        $hints = $repository->findBy($searchParams, $orderParams);
        $hintCount = count($hints);

        $repository = $entityManager->getRepository("Log");
        $searchParams = array('hunt' => $curHunt->getId(),
                                         'clue' => $curClue->getId(),
                                         'direction' => LogTypes::DIRECTION_OUTGOING,
                                         'type' => LogTypes::TYPE_HINT,
                                         'state' => 1);
        $logs = $repository->findBy($searchParams);
        $hintsSent = count($logs);

        $curHint = $hints[$hintsSent % $hintCount];

        return $curHint;
    }

    static function FindStoryByCode($code, $entityManager)
    {
        $repository = $entityManager->getRepository("Story");
        $story = $repository->findOneBy(array('code' => strtoupper($code), 'state' => 1));

        return $story;        
    }

    static function FindHuntByCode($code, $entityManager)
    {
        $repository = $entityManager->getRepository("Hunt");
        $hunt = $repository->findOneBy(array('code' => strtoupper($code), 'end' => null, 'state' => 1));

        return $hunt;
    }

    function AddHuntToStory($story)
    {
        $hunt = (object) [
            'id' => -1,
            'start' => "",
            'end' => "",
            'hintsUsed' => 0,
            'code' => '',
            'clue' => -1,
            'maxUsers' => $story->getMaxUsers(),
            'story' => $story->getID(),
            'party' => -1
        ];

        return createHunt($hunt, $this->entityManager);
    }

    function AddUserToHunt($hunt)
    {
        $fromPhone = $this->message["From"];
        $curParty = $hunt->getParty();

        if (!isset($curParty)) //if the hunt has no party set then lets create one
        {
            $party = new Party();

            $this->entityManager->persist($party);

            $hunt->setParty($party);
            $this->entityManager->flush();

            $curParty = $party;
        }

        if (!isset($this->user))
        {
            $user = (object) [
                'id' => -1,
                'name' => '',
                'email' => '',
                'phone' => (string) $fromPhone,
                'party' => $curParty->getId(),
              ];

            try { addEditUser($user, $this->entityManager); } catch(Exception $e) {return $e->getMessage();};
        }
        else
        {
            if (isset($this->party))
            {
                if ($this->party->getId() == $curParty->getId())
                {
                    return "You've already joined this group.";
                }
                else
                {
                    return "You're already registered to a group - you'll have to text 'quit party' to join this one.";
                }
            }

            $user = (object) [
                'id' => $this->user->getId(),
                'name' => $this->user->getName(),
                'email' => $this->user->getEmail(),
                'phone' => $this->user->getPhone(),
                'party' => $curParty->getId(),
              ];

            try { addEditUser($user, $this->entityManager); } catch(Exception $e) {return $e->getMessage();};
        }

        return "You've joined the party!";
    }

    function replace_variables($message_out)
    {
        $matches = [];
        preg_match_all('/\[((?:a\d+)+)(?:,(\d+)?)?(?:,(.+)?)?]/', $message_out, $matches);

        if (count($matches[1]) > 0)
        {
            $answers = $matches[1][0];  //answers
            $maxChars = $matches[2][0]; //maxChars

            $value = $matches[3][0];    //default

            $answerList = explode('a', trim($answers, "a"));

            foreach ($answerList as $answerID) {
                
                if (isset($this->answer) && $this->answer->getId() == $answerID)
                {
                    if (strlen($this->message["Body"]) <= $maxChars)
                    {
                        $value = $this->message["Body"];
                        break;
                    }
                }
                else
                {
                    $repository = $this->entityManager->getRepository("Log");
                    $log = $repository->findOneBy(array('answer' => $answerID, 'hunt' => $this->hunt, 'type' => 3), array('id' => 'DESC'));

                    if (isset($log))
                    {
                        if (strlen($log->getValue()) <= $maxChars)
                        {
                            $value = $log->getValue();
                            break;
                        }
                    }
                }
            }

            $value = preg_replace('/\^|\&|Ø|<|>/', "", $value);

            return preg_replace('/\[((?:a\d+)+)(?:,(\d+)?)?(?:,(.+)?)?]/', $value, $message_out);
        }

        return $message_out;

        
    }
}
