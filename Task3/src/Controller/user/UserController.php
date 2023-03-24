<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route("user/get/{id}", methods: "GET")]
    public function getItem(int $id): Response
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $data = [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'phoneNumber' => $user->getPhoneNumber()
        ];

        return $this->json($data);
    }



    #[Route("user/getitems/{id}", methods: "GET")]
    public function getItems(Request $request): Response
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();

        if (!$users) {
            throw $this->createNotFoundException('Users not found');
        }

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'phoneNumber' => $user->getPhoneNumber()
            ];
        }

        return $this->json($data);
    }



    #[Route("user/create}", methods: "POST")]
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setUsername($data['username']);
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setPhoneNumber($data['phoneNumber']);

        $this->entityManager->persist($user);

        $this->entityManager->flush();

        return $this->json(['message' => 'User successfully created']);
    }



    #[Route("user/put/{id}", methods: "PUT")]
    public function put(Request $request, $id): Response
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('There is no user with such id: ' . $id);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['username'])) {
            $user->setUsername($data['username']);
        }

        if (isset($data['firstName'])) {
            $user->setFirstName($data['firstName']);
        }

        if (isset($data['lastName'])) {
            $user->setLastName($data['lastName']);
        }

        if (isset($data['phoneNumber'])) {
            $user->setPhoneNumber($data['phoneNumber']);
        }

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json(['message' => 'User successfully updated']);
    }



    #[Route("user/patch/{id}", methods: "PATCH")]
    public function patch(Request $request, int $id): Response
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->json(['error' => 'This user not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['username'])) {
            $user->setUsername($data['username']);
        }

        if (isset($data['firstName'])) {
            $user->setFirstName($data['firstName']);
        }

        if (isset($data['lastName'])) {
            $user->setLastName($data['lastName']);
        }

        if (isset($data['phoneNumber'])) {
            $user->setPhoneNumber($data['phoneNumber']);
        }

        $this->entityManager->flush();

        return $this->json(['message' => 'User successfully updated']);
    }



    #[Route("user/delete/{id}", methods: "DELETE")]
    public function delete(int $id): Response
    {
        $user = $this->entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->json(['message' => 'User successfully deleted']);
    }
}