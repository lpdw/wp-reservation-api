<?php
/**
 * Participation Class File.
 * @version 1.0
 * @author Elias Cédric Laouiti
 * @author Maxime Florile
 * Date: 04/01/2016
 * Project: OpenBooking
 * @copyright 2015 - 2016 OpenBooking Group
 *
 */

namespace OpenBooking;
use \PDOException;
use \PDO;
use \Exception;
use OpenBooking\Exceptions\AccessDeniedException;
use OpenBooking\Exceptions\SQLErrorException;
use OpenBooking\Exceptions\UnknowErrorException;
use OpenBooking\Exceptions\ValidDatasException;
use OpenBooking\model;

/**
 * Class Participation
 * @package OpenBooking
 */
class Participation
{
    /**
     * Participation id
     * @var int $id
     */
    private $id;

    /**
     * Participant id
     * @var int $id_participant
     */
    private $id_participant;

    /**
     * Event id
     * @var int $id_event
     */
    private $id_event;

    /**
     * Comment about the participation
     * @var string $comments
     */
    private $comments;

    /**
     * Participation cancelled
     *
     * If cancelled == 0 => Participation NOT cancelled else if cancelled == 1, participation was cancelled
     * @var bool $cancelled
     */
    private $cancelled;

    /**
     * Participant present
     *
     * If present == 0 => Participant wasn't at the event else if present == 1, Participant was present at the event
     * @var bool $present
     */
    private $present;

    /**
     * @ignore
     */
    private $pdo;

    /**
     * Participation constructor.
     * @param int $id_participant
     * @param int $id_event
     * @throws AccessDeniedException
     * @throws SQLErrorException
     * @throws UnknowErrorException
     */
    public function __construct($id_participant, $id_event)
    {
        try {
            $sql = "SELECT * FROM ob_participation WHERE id_participant = :id_participant AND id_event = :id_event";
            $this->pdo = $GLOBALS['pdo'];
            $req = $this->pdo->prepare($sql);
            $req->bindParam(":id_event", $id_event);
            $req->bindParam(":id_participant", $id_participant);
            $req->setFetchMode(PDO::FETCH_OBJ);
            $req->execute();
            $res = $req->fetch();

            if(isset($res->id)){
                $this->id_participant = $id_participant;
                $this->id_event = $id_event;
                $this->cancelled = $res->cancelled;
                $this->id = $res->id;
                $this->comments = $res->comments;
                $this->present = $res->present;

            } else {
                throw new AccessDeniedException();
            }
        } catch (PDOException $e) {
            throw new SQLErrorException($e->getMessage());
        } catch (AccessDeniedException $e) {
            throw new AccessDeniedException();
        } catch (Exception $e) {
            throw new UnknowErrorException();
        }
    }

    /**
     * Get the participations infos
     * @return model\ModelParticipation
     */
    public function get(){
        $res = new model\ModelParticipation();
        $res->id                = $this->id;
        $res->id_event          = $this->id_event;
        $res->id_participant    = $this->id_participant;
        $res->comments          = $this->comments;
        $res->cancelled         = $this->cancelled;
        $res->present           = $this->present;
        return $res;
    }

    /**
     * Get the participation ID
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the participant ID
     *
     * @return int
     */
    public function getIdParticipant()
    {
        return $this->id_participant;
    }

    /**
     * Get the event ID
     * @return int
     */
    public function getIdEvent()
    {
        return $this->id_event;
    }

    /**
     * Get If the participant was present at the event
     * If present == 0 => Participant wasn't at the event else if present == 1, Participant was present at the event
     *
     * @return boolean
     */
    public function isPresent()
    {
        return $this->present;
    }

    /**
     * Set if participant was present and save it into database
     * If present == 0 => Participant wasn't at the event else if present == 1, Participant was present at the event
     *
     * @param boolean $present
     * @throws SQLErrorException
     * @throws UnknowErrorException
     * @throws ValidDatasException
     */
    public function setPresent($present)
    {
        if($present != 0 && $present != 1){
            throw new ValidDatasException("Data present is not valid. Boolean expected");
        }
        try {
            $sql = "UPDATE ob_participation SET present = :present WHERE id = :id ";
            $req = $this->pdo->prepare($sql);
            $req->bindParam(":present", $present);
            $req->bindParam(":id", $this->id);
            $req->execute();
            $this->present = $present;

        } catch (PDOException $e) {
            throw new SQLErrorException($e->getMessage());
        } catch (Exception $e) {
            throw new UnknowErrorException();
        }
    }

    /**
     * Get if participation is cancelled or not
     * If cancelled == 0 => Participant will be present  else if cancelled == 1, Participant will not be present at the event
     *
     * @return boolean
     */
    public function isCancelled()
    {
        return $this->cancelled;
    }

    /**
     * Set if the participation is cancelled or not.
     * If cancelled == 0 => Participant will be present else if cancelled == 1, Participant will not be present at the event
     * @param boolean $cancelled
     *
     * @throws SQLErrorException
     * @throws UnknowErrorException
     * @throws ValidDatasException
     */
    public function setCancelled($cancelled)
    {
        if($cancelled != 0 && $cancelled != 1){
            throw new ValidDatasException("Data present is not valid. Boolean expected");
        }
        try {
            $sql = "UPDATE ob_participation SET cancelled = :cancelled WHERE id = :id ";
            $req = $this->pdo->prepare($sql);
            $req->bindParam(":cancelled", $cancelled);
            $req->bindParam(":id", $this->id);
            $req->execute();
            $this->cancelled = $cancelled;
        } catch (PDOException $e) {
            throw new SQLErrorException($e->getMessage());
        } catch (Exception $e) {
            throw new UnknowErrorException();
        }
    }

    /**
     * Get the comment about the participation
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set comments and save it into database
     * @param string $comments
     *
     * @throws SQLErrorException
     * @throws UnknowErrorException
     */
    public function setComments($comments)
    {
        try {
            $sql = "UPDATE ob_participation SET comments = :comments WHERE id = :id ";
            $req = $this->pdo->prepare($sql);
            $req->bindParam(":comments", $comments);
            $req->bindParam(":id", $this->id);
            $req->execute();
            $this->comments = $comments;
        } catch (PDOException $e) {
            throw new SQLErrorException($e->getMessage());
        } catch (Exception $e) {
            throw new UnknowErrorException();
        }
    }

    /**
     * Add a new participant to an event.
     *
     * If we want to force a new participant, $force_creation need to be true. (Administrator only !)
     *
     * @param Participant $participant
     * @param Event $event
     * @param bool|false $force_creation
     * @return array
     * @throws AccessDeniedException
     * @throws SQLErrorException
     * @throws UnknowErrorException
     */
    static function add(Participant $participant, Event $event, $force_creation = false)
    {
        $id_participant = $participant->getId();
        $id_event = $event->getId();

        if(!$force_creation && $participant->getStatus() == "ban"){
            throw new AccessDeniedException("User ban, please contact the organizer");
        }
        try {
            $sql = "INSERT INTO ob_participation (id_participant, id_event) VALUES (:id_participant, :id_event)";
            $req = $GLOBALS['pdo']->prepare($sql);
            $req->bindParam(":id_event", $id_event);
            $req->bindParam(":id_participant", $id_participant);
            if($req->execute()){
                // Todo Send email
                return array("code" => 0, "message" => "ok");
            } else {
                throw new UnknowErrorException();
            }
        } catch (PDOException $e) {
            throw new SQLErrorException($e->getMessage());
        } catch (Exception $e) {
            throw new UnknowErrorException();
        }
    }

}