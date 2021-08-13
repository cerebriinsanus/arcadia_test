<?php

namespace App\Factory;

use App\Entity\Choice;
use App\Entity\Question;

class QuestionFactory
{
    /**
     * @param array $arr
     * @return Question
     * @throws \Exception
     */
    public static function createFromArray(array $arr): Question
    {
        $question = new Question();
        $question->setText($arr[0]);
        $question->setCreatedAt(new \DateTime($arr[1]));
        $choices = self::createChoices(array_slice($arr, 2));
        $question->setChoices($choices);
        return $question;
    }

    private static function createChoice(string $text): Choice
    {
        $choice = new Choice();
        $choice->setText($text);

        return $choice;
    }

    /**
     * @param array $rows
     * @return Choice[]
     */
    private static function createChoices(array $rows): array
    {
        $choices = [];
        foreach ($rows as $row) {
            $choices[] = self::createChoice($row);
        }

        return $choices;
    }
}
