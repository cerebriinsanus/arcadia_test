<?php

namespace App\Transformer;

use App\Entity\Question;

// TODO find a way to optimize requests count. So far we have one request per each question and option.
class QuestionTransformer
{
    private DataTransformer $transformer;

    /**
     * @param Question[] $questions
     * @return Question[]
     */
    public function transform(array $questions): array
    {
        foreach ($questions as $question) {
            $text = $this->transformer->transform($question->getText());
            $question->setText($text);
            foreach ($question->getChoices() as $choice) {
                $text = $this->transformer->transform($choice->getText());
                $choice->setText($text);
            }
        }

        return $questions;
    }

    public function getTransformer(): DataTransformer
    {
        return $this->transformer;
    }

    public function setTransformer(DataTransformer $transformer): void
    {
        $this->transformer = $transformer;
    }
}
