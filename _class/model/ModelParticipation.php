<?php
/**
 * ModelParticipation Class File.
 * @version 1.0
 * @author Elias Cédric Laouiti
 * @author Maxime Florile
 * Date: 04/01/2016
 * Project: OpenBooking
 * @copyright 2015 - 2016 OpenBooking Group
 *
 */

namespace OpenBooking\_Class\Model;

/**
 * Class ModelParticipation
 * @package OpenBooking\_Class\Model
 */
Class ModelParticipation
{
    /**
     * Participation id
     * @var int $id
     */
    public $id;

    /**
     * Participant id
     * @var int $id_participant
     */
    public $id_participant;

    /**
     * Event id
     * @var int $id_event
     */
    public $id_event;

    /**
     * Comment about the participation
     * @var string $comments
     */
    public $comments;

    /**
     * Participation canceled
     *
     * If canceled == 0 => Participation NOT canceled else if canceled == 1, participation was canceled
     * @var bool $canceled
     */
    public $canceled;

    /**
     * Participant present
     *
     * If present == 0 => Participant wasn't at the event else if present == 1, Participant was present at the event
     * @var bool $present
     */
    public $present;
}
