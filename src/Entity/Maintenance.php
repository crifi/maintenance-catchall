<?php


namespace App\Entity;


class Maintenance
{
    private ?string $host = null;

    private ?string $backend_name = null;

    private string $title = 'Maintenance';

    private int $httpStatuscode = 503;

    private string $text = 'Sorry, we are currently under maintenance';

    public function getHost(): ?string
    {
        return $this->host;
    }

    public function setHost(?string $host): Maintenance
    {
        $this->host = $host;
        return $this;
    }

    public function getBackendName(): ?string
    {
        return $this->backend_name;
    }

    public function setBackendName(?string $backend_name): void
    {
        $this->backend_name = $backend_name;
    }

    public function getTitle(): string
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