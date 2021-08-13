<?php

namespace App\Repository;

use App\Entity\Question;
use App\Factory\QuestionFactory;
use App\Helper\FileHelper;
use Symfony\Component\Serializer\SerializerInterface;

class QuestionCSVRepository implements QuestionRepositoryInterface
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
     * @throws \Exception
     */
    public function getAll(): array
    {
        $rows = $this->fileHelper->getContents();
        // should work, but does not.
        /*$res = $this->serializer->deserialize(
            $rows,
            'App\Entity\Question[]',
            "csv",
            ["no_headers"=>1,"as_collection"=>1]
        );*/
        $rows = explode("\n", $rows);
        $res = [];
        for ($row_num = 1; $row_num < count($rows); $row_num++) {
            if (!$rows[$row_num]) {
                continue;
            }
            $row = str_getcsv($rows[$row_num]);
            $res[] = QuestionFactory::CreateFromArray($row);
        }
        return $res;
    }

    public function addNew(Question $question): void
    {
        $str = $this->serializer->serialize($question, "csv", ["no_headers"=>1]);

        $this->fileHelper->appendFile($str);
    }
}
