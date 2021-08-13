<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepositoryInterface;
use App\Transformer\GoogleTranslateDataTransformer;
use App\Transformer\QuestionTransformer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class QuestionsController extends AbstractController
{
    public function list(
        Request $request,
        QuestionRepositoryInterface $repo,
        QuestionTransformer $transformer
    ): Response {
        try {
            $lang = $request->query->get("lang");
            $questions = $repo->getAll();
            $transformer->setTransformer(new GoogleTranslateDataTransformer($lang));
            return $this->json($transformer->transform($questions));
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function add(
        Request $request,
        ValidatorInterface $validator,
        QuestionRepositoryInterface $repo,
        SerializerInterface $serializer
    ): Response {
        try {
            $entity = $serializer->deserialize($request->getContent(), Question::class, "json");
            $errors = $validator->validate($entity);

            // TODO customize error messages
            if (count($errors)) {
                return $this->ErrorResponse((string) $errors, Response::HTTP_BAD_REQUEST);
            }

            $repo->addNew($entity);

            return $this->json([ "status" => "OK" ], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->ErrorResponse($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function ErrorResponse(string $message, int $status): Response
    {
        return $this->json([
            'status' => "Error",
            'message' => $message
        ], $status);
    }
}
