<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use App\Roigle\ApiHelper\FormUtil;
use App\Roigle\ApiHelper\ResponseJson;
use App\Service\FileUpload;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use DateTime;

/**
 * @Route("/comments", name="comments_")
 */
class CommentController
{
    /**
     * Get collection of UserFixture.
     *
     * @Route("", name="get_collection", methods={"GET"})
     *
     * @param Request $request
     * @param ResponseJson $response
     * @param CommentRepository $repository
     *
     * @return JsonResponse
     */
    public function getCollection(
        Request $request,
        ResponseJson $response,
        CommentRepository $repository
    ): JsonResponse {
        return $response->responseJson($repository->findByCriteria($request->query->all()));
    }

    /**
     * Get single resource of UserFixture.
     *
     * @Route("/{id}", name="get", methods={"GET"})
     *
     * @param ResponseJson $response
     * @param Comment $comment
     * @return JsonResponse
     */
    public function get(ResponseJson $response, Comment $comment): JsonResponse
    {
        return $response->responseJson($comment);
    }

    /**
     * Add onr resource of UserFixture
     *
     * @Route("", name="add", methods={"POST"})
     *
     * @param Request $request
     * @param ResponseJson $response
     * @param FormUtil $formUtil
     * @param EntityManagerInterface $manager
     *
     * @return JsonResponse
     */
    public function post(
        Request $request,
        ResponseJson $response,
        FormUtil $formUtil,
        EntityManagerInterface $manager
    ): JsonResponse {
        $comment = new Comment();
        $form = $formUtil->handleRequest($request, UserType::class, $comment);

        if (!$form->isValid()) {
            return $response->makeBadRequest($formUtil->getErrors($form));
        }

        $comment->setCreatedDate(new \DateTime('now'));

        $manager->persist($comment);
        $manager->flush();

        return $response->makeCreatedResponse('comments_get', ['id' => $form->getData()->getId()]);
    }

    /**
     *
     * @Route("/{id}", name="put", methods={"PUT"})
     *
     * @param Request $request
     * @param ResponseJson $response ,
     * @param FormUtil $formUtil
     * @param EntityManagerInterface $manager
     * @param CommentRepository $repository
     * @param int $id
     * @param FileUpload $fileUploader
     * @return JsonResponse
     * @throws \Exception
     */
    public function put(
        Request $request,
        ResponseJson $response,
        FormUtil $formUtil,
        EntityManagerInterface $manager,
        CommentRepository $repository,
        int $id,
        FileUpload $fileUploader
    ): JsonResponse {
        $comment= $repository->findOneBy(['id' => $id]);

        $data = json_decode($request->getContent());
        $comment->setDescription($data->data->description)
            ->setUser($data->data->user)
            ->setService($data->data->service)
            ->setUpdateDate(new \DateTime('now'));

        $manager->persist($comment);
        $manager->flush();
        return $response->emptyResponseJson();
    }

    /**
     * Delete one resource of UserFixture
     *
     * @Route("/{id}", name="delete", methods={"DELETE"})
     *
     * @param ResponseJson $responseFactory
     * @param EntityManagerInterface $manager
     *
     * @param CommentRepository $repository
     * @param int $id
     * @return JsonResponse
     */
    public function delete(
        ResponseJson $responseFactory,
        EntityManagerInterface $manager,
        CommentRepository $repository,
        int $id
    ): JsonResponse {
        $comment= $repository->findOneBy(['id' => $id]);
        $comment->setIsActive(!$comment->getIsActive())
                ->setDeletedDate(new \DateTime('now'));
        $manager->persist($comment);
        $manager->flush();
        return $responseFactory->emptyResponseJson();
    }
}
