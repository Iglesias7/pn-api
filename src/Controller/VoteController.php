<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Metier;
use App\Entity\Service;
use App\Entity\User;
use App\Entity\Vote;
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
 * @Route("/votes", name="votes_")
 */
class VoteController
{

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
        $vote = new Vote();
        $form = $formUtil->handleRequest($request, UserType::class, $vote);

        if (!$form->isValid()) {
            return $response->makeBadRequest($formUtil->getErrors($form));
        }

        $vote->setCreatedDate(new \DateTime('now'));

        $manager->persist($vote);
        $manager->flush();

        return $response->makeCreatedResponse('votes_get', ['id' => $form->getData()->getId()]);
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
     * @return JsonResponse
     */
    public function put(
        Request $request,
        ResponseJson $response,
        FormUtil $formUtil,
        EntityManagerInterface $manager,
        ServiceRepository $repository,
        int $id
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
}
