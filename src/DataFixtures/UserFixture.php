<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Metier;
use App\Entity\Service;
use App\Entity\User;
use App\Entity\Vote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        $admin = $this->addUser("admin", "administrator", "admin", "admin@gmail.com", "admin", 699999999, "admin");
        $manager->persist($admin);

        $manage = $this->addUser("manager", "mangement", "manager", "manager@gmail.com", "manager", 699999999, "manager");
        $manager->persist($manage);

        $armand = $this->addUser("armand", "Essomo", "armand", "armand@gmail.com", "armand", 699999999, "artisan");
        $manager->persist($armand);

        $iglesias = $this->addUser("iglesias", "chendjou", "iglesias", "iglesias@gmail.com", "iglesias", 699999999);
        $manager->persist($iglesias);

        $alvine = $this->addUser("alvine", "alvine", "alvine", "alvine@gmail.com", "alvine", 699999999, "artisan");
        $manager->persist($alvine);

        $patric = $this->addUser("patric", "patric", "patric", "patric@gmail.com", "patric", 699999999, "artisan");
        $manager->persist($patric);

        $services1 = $this->addService("service1", "Une des raisons pour lesquelles les cartes de visite sont toujours en circulation c'est
         du fait qu'elles fournissent facilement les informations de contact, car le
         s coordonnées d'une entreprise sont extrêmement essentielles pour les clients. ", 20000, $armand);
        $manager->persist($services1);

        $services2 = $this->addService(
                                    "service2", "Une des raisons pour lesquelles les cartes de visite sont toujours en circulation c'est du fait qu'elles fournissent facilement les informations de contact, car les coordonnées d'une entreprise sont extrêmement essentielles pour les clients. ",
                                    20000,
                                    $armand
                                );
        $manager->persist($services2);

        $services3 = $this->addService("service3", "Une des raisons pour lesquelles les cartes de visite sont toujours en circulation c'est
         du fait qu'elles fournissent facilement les informations de contact, car le
         s coordonnées d'une entreprise sont extrêmement essentielles pour les clients. ", 15000, $patric);
        $manager->persist($services3);

        $services4 = $this->addService("service4", "Une des raisons pour lesquelles les cartes de visite sont toujours en circulation c'est
         du fait qu'elles fournissent facilement les informations de contact, car le
         s coordonnées d'une entreprise sont extrêmement essentielles pour les clients. ", 6000, $patric);
        $manager->persist($services4);

        $services5 = $this->addService("service5", "Une des raisons pour lesquelles les cartes de visite sont toujours en circulation c'est
         du fait qu'elles fournissent facilement les informations de contact, car le
         s coordonnées d'une entreprise sont extrêmement essentielles pour les clients. ", 2000, $patric);
        $manager->persist($services5);

        $services6 = $this->addService("service6", "Une des raisons pour lesquelles les cartes de visite sont toujours en circulation c'est
         du fait qu'elles fournissent facilement les informations de contact, car le
         s coordonnées d'une entreprise sont extrêmement essentielles pour les clients. ", 32000, $alvine);
        $manager->persist($services6);

        $services7 = $this->addService("service7", "Une des raisons pour lesquelles les cartes de visite sont toujours en circulation c'est
         du fait qu'elles fournissent facilement les informations de contact, car le
         s coordonnées d'une entreprise sont extrêmement essentielles pour les clients. ", 1500, $armand);
        $manager->persist($services7);

        $services8 = $this->addService("service8", "Une des raisons pour lesquelles les cartes de visite sont toujours en circulation c'est
         du fait qu'elles fournissent facilement les informations de contact, car le
         s coordonnées d'une entreprise sont extrêmement essentielles pour les clients. ", 500, $alvine);
        $manager->persist($services8);

        $services9 = $this->addService("service9", "Une des raisons pour lesquelles les cartes de visite sont toujours en circulation c'est
         du fait qu'elles fournissent facilement les informations de contact, car le
         s coordonnées d'une entreprise sont extrêmement essentielles pour les clients. ", 1300, $alvine);
        $manager->persist($services9);

        $Photographe = $this->addMetier("Photographe");
        $manager->persist($Photographe);

        $Designer = $this->addMetier("Designer");
        $manager->persist($Designer);

        $maçon = $this->addMetier("maçon");
        $manager->persist($maçon);

        $benskineur = $this->addMetier("benskineur");
        $manager->persist($benskineur);

        $creuseur = $this->addMetier("creuseur");
        $manager->persist($creuseur);

        $développeur = $this->addMetier("développeur");
        $manager->persist($développeur);

        $gestionnaire = $this->addMetier("gestionnaire");
        $manager->persist($gestionnaire);

        $services1->addMetier($benskineur);
        $services2->addMetier($creuseur);
        $services1->addMetier($creuseur);
        $services3->addMetier($Designer);
        $services6->addMetier($Designer);

        $manager->flush();
    }

    public function addUser(
        string $pseudo,
        string $firstname,
        string $lastname,
        string $email,
        string $password,
        string $phonenumber,
        string $role = "client"
    ){
        $user = new User();
        $user->setPseudo($pseudo)
            ->setFirstName($firstname)
            ->setLastName($lastname)
            ->setEmail($email)
            ->setPhoneNumber($phonenumber)
            ->setRole($role)
            ->setPassword($this->passwordEncoder->encodePassword($user, $password))
            ->setCreatedDate(new \DateTime('now'));

        return $user;
    }

    public function addService(
        string $name,
        string $description,
        string $price,
        User $user
    ){
        $service = new Service();
        $service->setName($name)
            ->setDescription($description)
            ->setPrice($price)
            ->setUser($user)
            ->setCreatedDate(new \DateTime('now'));

        return $service;
    }

    public function addComment(
        string $description,
        Service $service,
        User $user
    ) {
        $comment = new Comment();
        $comment->setDescription($description)
            ->setService($service)
            ->setUser($user)
            ->setCreatedDate(new \DateTime('now'));

        return $comment;
    }

    public function addVote(
        int $updown,
        Service $service,
        User $user
    ) {
        $vote = new Vote();
        $vote->setUpDown($updown)
            ->setService($service)
            ->setUser($user);

        return $vote;
    }

    public function addMetier(
        string $name
    ) {
        $metier = new Metier();
        $metier->setName($name)
            ->setCreatedDate(new \DateTime('now'))
        ->setIsActive(true);

        return $metier;
    }
}
