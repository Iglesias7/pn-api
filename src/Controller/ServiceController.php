<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Metier;
use App\Entity\Service;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\CommentRepository;
use App\Repository\MetierRepository;
use App\Repository\ServiceRepository;
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
 * @Route("/services", name="services_")
 */
class ServiceController
{
    /**
     * Get collection of UserFixture.
     *
     * @Route("", name="get_collection", methods={"GET"})
     *
     * @param Request $request
     * @param ResponseJson $response
     * @param ServiceRepository $repository
     *
     * @return JsonResponse
     */
    public function getCollection(
        Request $request,
        ResponseJson $response,
        ServiceRepository $repository
    ): JsonResponse {
        return $response->responseJson($repository->findByCriteria($request->query->all()));
    }

    /**
     * Get single resource of UserFixture.
     *
     * @Route("/{id}", name="get", methods={"GET"})
     *
     * @param ResponseJson $response
     * @param Service $service
     * @return JsonResponse
     */
    public function get(ResponseJson $response, Service $service): JsonResponse
    {
        return $response->responseJson($service);
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
        $service = new Service();
        $form = $formUtil->handleRequest($request, UserType::class, $service);

        if (!$form->isValid()) {
            return $response->makeBadRequest($formUtil->getErrors($form));
        }

        $service->setCreatedDate(new \DateTime('now'));

        $manager->persist($service);
        $manager->flush();

        return $response->makeCreatedResponse('services_get', ['id' => $form->getData()->getId()]);
    }

    /**
     *
     * @Route("/{id}", name="put", methods={"PUT"})
     *
     * @param Request $request
     * @param ResponseJson $response ,
     * @param FormUtil $formUtil
     * @param EntityManagerInterface $manager
     * @param ServiceRepository $repository
     * @param int $id
     * @param FileUpload $fileUploader
     * @return JsonResponse
     */
    public function put(
        Request $request,
        ResponseJson $response,
        FormUtil $formUtil,
        EntityManagerInterface $manager,
        ServiceRepository $repository,
        int $id,
        FileUpload $fileUploader
    ): JsonResponse {
        $service = $repository->findOneBy(['id' => $id]);

        $data = json_decode($request->getContent());
        $service->setName($data->data->name)
            ->setDescription($data->data->description)
            ->setPrice($data->data->price)
            ->setUpdateDate(new \DateTime('now'));

        $manager->persist($service);
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
     * @param ServiceRepository $repository
     * @param int $id
     * @return JsonResponse
     */
    public function delete(
        ResponseJson $responseFactory,
        EntityManagerInterface $manager,
        ServiceRepository $repository,
        int $id
    ): JsonResponse {
        $service= $repository->findOneBy(['id' => $id]);
        $service->setIsActive(!$service->getIsActive())
            ->setDeletedDate(new \DateTime('now'));
        $manager->persist($service);
        $manager->flush();
        return $responseFactory->emptyResponseJson();
    }
}
