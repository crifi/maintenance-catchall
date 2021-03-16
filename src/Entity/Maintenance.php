<?php


namespace App\Entity;


class Maintenance
{
    private $host = '/.*/';

    private $title = 'Maintenance';

    private $httpStatuscode = 503;

    private $text = 'Sorry, we are currently under maintenance';

    public function getHost(): string
    {
        return $this->host;
    }

    public function setHost(string $host): Maintenance
    {
        $this->host = $host;
        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle(string $title): Maintenance
    {
        $this->title = $title;
        return $this;
    }

    public function getHttpStatuscode(): int
    {
        return $this->httpStatuscode;
    }

    public function setHttpStatuscode(int $httpStatuscode): Maintenance
    {
        $this->httpStatuscode = $httpStatuscode;
        return $this;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): Maintenance
    {
        $this->text = $text;
        return $this;
    }
}