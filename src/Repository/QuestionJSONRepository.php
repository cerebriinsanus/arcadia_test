<?php

namespace App\Repository;

use App\Entity\Question;
use App\Helper\FileHelper;
use Symfony\Component\Serializer\SerializerInterface;

// Maybe I could use some abstract class with protected SerializerInterface and FileHelper,
// but in the future not all Repositories shall need it, so I decided against it.
class QuestionJSONRepository implements QuestionRepositoryInterface
{
    private SerializerInterface $serializer;
    private FileHelper $fileHelper;

    public function __construct(string $filename, SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
        $this->fileHelper = new FileHelper($filename);
    }

    /**
     * @return Question[]
     */
    public function getAll(): array
    {
        return $this->readAll();
    }

    public function addNew(Question $question): void
    {
        $data = $this->readAll();
        $data[] = $question;
        $str = $this->serializer->serialize($data, "json");

        $this->fileHelper->WriteToFile($str);
    }

    /**
     * @return Question[]
     */
    private function readAll(): array
    {
        $json = $this->fileHelper->getContents();
        return $this->serializer->deserialize($json, "App\Entity\Question[]", "json");
    }
}
