<?php
declare(strict_types=1);

namespace Gumeniukcom\SM\Entity;


use Exception;

class Post implements PostInterface
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @var string
     */
    private string $from_name;

    /**
     * @var string
     */
    private string $from_id;

    /**
     * @var string
     */
    private string $message;

    /**
     * @var string
     */
    private string $type;

    /**
     * @var \DateTimeImmutable
     */
    private \DateTimeImmutable $created_time;

    /**
     * Post constructor.
     * @param string $id
     * @param string $from_name
     * @param string $from_id
     * @param string $message
     * @param string $type
     * @param \DateTimeImmutable $created_time
     */
    public function __construct(
        string $id,
        string $from_name,
        string $from_id,
        string $message,
        string $type,
        \DateTimeImmutable $created_time
    ) {
        $this->id = $id;
        $this->from_name = $from_name;
        $this->from_id = $from_id;
        $this->message = $message;
        $this->type = $type;
        $this->created_time = $created_time;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFromName(): string
    {
        return $this->from_name;
    }

    /**
     * @return string
     */
    public function getFromId(): string
    {
        return $this->from_id;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedTime(): \DateTimeImmutable
    {
        return $this->created_time;
    }

    /**
     * @return string
     */
    public function getCreatedYearMonth(): string
    {
        return $this->getCreatedTime()->format('Y.m');
    }

    /**
     * @return string
     */
    public function getCreatedWeek(): string
    {
        return $this->getCreatedTime()->format('W');
    }

    /**
     * @return int
     */
    public function getMessageLength(): int
    {
        return mb_strlen($this->getMessage());
    }
}