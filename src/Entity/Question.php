<?php

namespace App\Entity;

class Question
{
    private string $text;
    private \DateTimeInterface $createdAt;
    /** @var Choice[]  */
    private array $choices;

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return Choice[]
     */
    public function getChoices(): array
    {
        return $this->choices;
    }

    /**
     * @param Choice[] $choices
     */
    public function setChoices(array $choices): void
    {
        $this->choices = $choices;
    }

}
