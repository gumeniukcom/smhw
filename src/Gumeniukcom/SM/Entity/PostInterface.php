<?php
declare(strict_types=1);

namespace Gumeniukcom\SM\Entity;


interface PostInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getFromName(): string;

    /**
     * @return string
     */
    public function getFromId(): string;

    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedTime(): \DateTimeImmutable;

    /**
     * @return int
     */
    public function getMessageLength(): int;

    /**
     * @return string
     */
    public function getCreatedYearMonth(): string;

    /**
     * @return string
     */
    public function getCreatedWeek(): string;

}