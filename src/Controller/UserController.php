<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
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
 * @Route("/users", name="users_")
 */
class UserController
{
    /**
     * Get collection of UserFixture.
     *
     * @Route("", name="get_collection", methods={"GET"})
     *
     * @param Request $request
     * @param ResponseJson $response
     * @param UserRepository $repository
     *
     * @return JsonResponse
     */
    public function getCollection(
        Request $request,
        ResponseJson $response,
        UserRepository $repository
    ): JsonResponse {
        return $response->responseJson($repository->findByCriteria($request->query->all()));
    }

    /**
     * Get single resource of UserFixture.
     *
     * @Route("/{id}", name="get", methods={"GET"})
     *
     * @param ResponseJson $response
     * @param User $user
     *
     * @return JsonResponse
     */
    public function get(ResponseJson $response, User $user): JsonResponse
    {
        return $response->responseJson($user);
    }

    /**
     * Add onr resource of UserFixture
     *
     * @Route("", name="add", methods={"POST"})
     *
     * @param Request $request
     * @param ResponseJson $response
     * @param FormUtil $formUtil
     * @param UserPasswordEncoderInterface $userPasswordEncoderInterface
     * @param EntityManagerInterface $manager
     *
     * @return JsonResponse
     */
    public function post(
        Request $request,
        ResponseJson $response,
        FormUtil $formUtil,
        UserPasswordEncoderInterface $userPasswordEncoderInterface,
        EntityManagerInterface $manager
    ): JsonResponse {
        $user = new User();
        $form = $formUtil->handleRequest($request, UserType::class, $user);

        if (!$form->isValid()) {
            return $response->makeBadRequest($formUtil->getErrors($form));
        }

        $user->setPassword($userPasswordEncoderInterface->encodePassword($user, $user->getPassword()))
            ->setCreatedDate(new \DateTime('now'));

        $manager->persist($user);
        $manager->flush();

        return $response->makeCreatedResponse('users_get', ['id' => $form->getData()->getId()]);
    }

    /**
     *
     * @Route("/{id}", name="put", methods={"PUT"})
     *
     * @param Request $request
     * @param ResponseJson $response,
     * @param FormUtil $formUtil
     * @param EntityManagerInterface $manager
     * @param UserRepository $repository
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
        UserRepository $repository,
        int $id,
        FileUpload $fileUploader
    ): JsonResponse {
        $user= $repository->findOneBy(['id' => $id]);

        $data = json_decode($request->getContent());
        $date = new DateTime($data->data->birthdate);
        $user->setFirstName($data->data->firstName)
            ->setLastName($data->data->lastName)
            ->setLangue($data->data->langue)
            ->setBirthdate($date)
            ->setAdressDescription($data->data->adressDescription)
            ->setCity($data->data->city)
            ->setDescription($data->data->description)
            ->setPhoneNumber($data->data->phoneNumber)
            ->setStreet($data->data->street)
            ->setPostalCode($data->data->postalCode)
            ->setQualification($data->data->qualification)
            ->setLandLinePhoneNumber($data->data->landLinePhoneNumber)
            ->setUpdateDate(new \DateTime('now'));

        $manager->persist($user);
        $manager->flush();
        return $response->emptyResponseJson();
    }

    /**
     *
     * @Route("/login/{id}", name="put", methods={"PUT"})
     *
     * @param ResponseJson $response,
     * @param EntityManagerInterface $manager
     * @param UserRepository $repository
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function login(
        ResponseJson $response,
        EntityManagerInterface $manager,
        UserRepository $repository,
        int $id
    ): JsonResponse {
        $user= $repository->findOneBy(['id' => $id]);

        $user->setLastLoginDate(new \DateTime('now'))
             ->setIsLogin(true);

        $manager->persist($user);
        $manager->flush();
        return $response->emptyResponseJson();
    }

    /**
     *
     * @Route("/logout/{id}", name="put", methods={"PUT"})
     *
     * @param ResponseJson $response,
     * @param EntityManagerInterface $manager
     * @param UserRepository $repository
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function logout(
        ResponseJson $response,
        EntityManagerInterface $manager,
        UserRepository $repository,
        int $id
    ): JsonResponse {
        $user= $repository->findOneBy(['id' => $id]);

        $user->setIsLogin(false);

        $manager->persist($user);
        $manager->flush();
        return $response->emptyResponseJson();
    }

    /**
     *
     * @Route("/active/{id}", name="put", methods={"PUT"})
     *
     * @param ResponseJson $response,
     * @param EntityManagerInterface $manager
     * @param UserRepository $repository
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function active(
        ResponseJson $response,
        EntityManagerInterface $manager,
        UserRepository $repository,
        int $id
    ): JsonResponse {
        $user= $repository->findOneBy(['id' => $id]);

        $user->setIsActive(!$user->getIsActive());

        $manager->persist($user);
        $manager->flush();
        return $response->emptyResponseJson();
    }

    /**
     *
     * @Route("/verified/{id}", name="put", methods={"PUT"})
     *
     * @param ResponseJson $response,
     * @param EntityManagerInterface $manager
     * @param UserRepository $repository
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function verified(
        ResponseJson $response,
        EntityManagerInterface $manager,
        UserRepository $repository,
        int $id
    ): JsonResponse {
        $user= $repository->findOneBy(['id' => $id]);

        $user->setIsVerified(!$user->getIsVerified());

        $manager->persist($user);
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
     * @param UserRepository $repository
     * @param int $id
     * @return JsonResponse
     */
    public function delete(
        ResponseJson $responseFactory,
        EntityManagerInterface $manager,
        UserRepository $repository,
        int $id
    ): JsonResponse {
        $user= $repository->findOneBy(['id' => $id]);
        $user->setIsActive(!$user->getIsActive())
             ->setDeletedDate(new \DateTime('now'));
        $manager->persist($user);
        $manager->flush();
        return $responseFactory->emptyResponseJson();
    }
}
