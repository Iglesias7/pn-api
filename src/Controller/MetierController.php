<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Metier;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\CommentRepository;
use App\Repository\MetierRepository;
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
 * @Route("/metiers", name="metiers_")
 */
class MetierController
{
    /**
     * Get collection of UserFixture.
     *
     * @Route("", name="get_collection", methods={"GET"})
     *
     * @param Request $request
     * @param ResponseJson $response
     * @param MetierRepository $repository
     *
     * @return JsonResponse
     */
    public function getCollection(
        Request $request,
        ResponseJson $response,
        MetierRepository $repository
    ): JsonResponse {
        return $response->responseJson($repository->findByCriteria($request->query->all()));
    }

    /**
     * Get single resource of UserFixture.
     *
     * @Route("/{id}", name="get", methods={"GET"})
     *
     * @param ResponseJson $response
     * @param Metier $metier
     * @return JsonResponse
     */
    public function get(ResponseJson $response, Metier $metier): JsonResponse
    {
        return $response->responseJson($metier);
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
        $metier = new Metier();
        $form = $formUtil->handleRequest($request, UserType::class, $metier);

        if (!$form->isValid()) {
            return $response->makeBadRequest($formUtil->getErrors($form));
        }

        $metier->setCreatedDate(new \DateTime('now'));

        $manager->persist($metier);
        $manager->flush();

        return $response->makeCreatedResponse('metiers_get', ['id' => $form->getData()->getId()]);
    }

    /**
     *
     * @Route("/{id}", name="put", methods={"PUT"})
     *
     * @param Request $request
     * @param ResponseJson $response ,
     * @param FormUtil $formUtil
     * @param EntityManagerInterface $manager
     * @param MetierRepository $repository
     * @param int $id
     * @param FileUpload $fileUploader
     * @return JsonResponse
     */
    public function put(
        Request $request,
        ResponseJson $response,
        FormUtil $formUtil,
        EntityManagerInterface $manager,
        MetierRepository $repository,
        int $id,
        FileUpload $fileUploader
    ): JsonResponse {
        $metier = $repository->findOneBy(['id' => $id]);

        $data = json_decode($request->getContent());
        $metier->setName($data->data->name)
            ->setUpdateDate(new \DateTime('now'));

        $manager->persist($metier);
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
     * @param MetierRepository $repository
     * @param int $id
     * @return JsonResponse
     */
    public function delete(
        ResponseJson $responseFactory,
        EntityManagerInterface $manager,
        MetierRepository $repository,
        int $id
    ): JsonResponse {
        $metier= $repository->findOneBy(['id' => $id]);
        $metier->setIsActive(!$metier->getIsActive())
            ->setDeletedDate(new \DateTime('now'));
        $manager->persist($metier);
        $manager->flush();
        return $responseFactory->emptyResponseJson();
    }
}
