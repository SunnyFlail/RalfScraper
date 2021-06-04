<?php

namespace RalfScraper;

use JsonSerializable;

class Result implements JsonSerializable
{

    private string $name;
    private string $link;

    public function __construct(string $name, string $link)
    {
        $this->name = $name;
        $this->link = $link;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function jsonSerialize(): array
    {
        return [
            "name" => $this->name, 
            "link" => $this->link, 
        ];
    }

}