<?php

namespace App\Repository;

use App\Entity\Question;

interface QuestionRepositoryInterface
{
    /** @return Question[] */
    public function getAll(): array;

    public function addNew(Question $question): void;
}
