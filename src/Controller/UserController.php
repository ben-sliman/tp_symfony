<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Preference;
use App\Repository\UserRepository;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\{
    JsonResponse,
    Request,
    Response
};
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route("/users")]
class UserController extends AbstractController
{
    private EntityManagerInterface $em;
    private UserRepository $userRepository;
    private RoleRepository $roleRepository;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(
        EntityManagerInterface $em,
        UserRepository $userRepository,
        RoleRepository $roleRepository,
        UserPasswordHasherInterface $passwordHasher
    ) {
        $this->em = $em;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->passwordHasher = $passwordHasher;
    }

    // GET /users : Liste tous les utilisateurs
    #[Route("", name: "user_list", methods: ["GET"])]
    public function listUsers(): JsonResponse
    {
        $users = $this->userRepository->findAll();
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id'         => $user->getId(),
                'email'      => $user->getEmail(),
                'nom'        => $user->getNom(),
                'prenom'     => $user->getPrenom(),
                'createdAt'  => $user->getCreatedAt()->format('Y-m-d H:i:s'),
                'roles'      => $user->getRoles(),
            ];
        }
        return $this->json($data);
    }

    // GET /users/{id} : Affiche les détails d’un utilisateur
    #[Route("/{id}", name:"user_show", methods: ["GET"])]
    public function showUser(int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            return $this->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        $data = [
            'id'         => $user->getId(),
            'email'      => $user->getEmail(),
            'nom'        => $user->getNom(),
            'prenom'     => $user->getPrenom(),
            'createdAt'  => $user->getCreatedAt()->format('Y-m-d H:i:s'),
            'roles'      => $user->getRoles(),
        ];
        return $this->json($data);
    }

    // POST /users : Crée un utilisateur via le repository
    #[Route("", name:"user_create", methods: ["POST"])]
    public function createUser(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return $this->json(['message' => 'Invalid data'], Response::HTTP_BAD_REQUEST);
        }
        // La logique de création est déléguée au repository.
        $user = $this->userRepository->createUser($data, $this->roleRepository);
        return $this->json(['message' => 'User created', 'id' => $user->getId()], Response::HTTP_CREATED);
    }

    // PUT /users/{id} : Modifie un utilisateur via le repository
    #[Route("/{id}", name:"user_update", methods: ["PUT"])]
    public function updateUser(Request $request, int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            return $this->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return $this->json(['message' => 'Invalid data'], Response::HTTP_BAD_REQUEST);
        }
        // La logique de mise à jour est déléguée au repository.
        $this->userRepository->updateUser($user, $data, $this->roleRepository);
        return $this->json(['message' => 'User updated']);
    }

    // DELETE /users/{id} : Supprime un utilisateur
    #[Route("/{id}", name:"user_delete", methods: ["DELETE"])]
    public function deleteUser(int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            return $this->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        $this->em->remove($user);
        $this->em->flush();
        return $this->json(['message' => 'User deleted']);
    }

    // GET /users/{id}/preferences : Affiche les préférences d’un utilisateur
    #[Route("/{id}/preferences", name:"user_preference_show", methods: ["GET"])]
    public function showUserPreference(int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            return $this->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        $preference = $user->getPreference();
        if (!$preference) {
            return $this->json(['message' => 'Preferences not set']);
        }
        $data = [
            'langue'        => $preference->getLangue(),
            'theme'         => $preference->getTheme(),
            'notifications' => $preference->getNotifications(),
        ];
        return $this->json($data);
    }

    // PUT /users/{id}/preferences : Modifie les préférences d’un utilisateur
    #[Route("/{id}/preferences", name:"user_preference_update", methods: ["PUT"])]
    public function updateUserPreference(Request $request, int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            return $this->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return $this->json(['message' => 'Invalid data'], Response::HTTP_BAD_REQUEST);
        }
        $preference = $user->getPreference();
        if (!$preference) {
            $preference = new Preference();
            $user->setPreference($preference);
        }
        if (isset($data['langue'])) {
            $preference->setLangue($data['langue']);
        }
        if (isset($data['theme'])) {
            $preference->setTheme($data['theme']);
        }
        if (isset($data['notifications'])) {
            $preference->setNotifications($data['notifications']);
        }
        $this->em->flush();
        return $this->json(['message' => 'Preferences updated']);
    }
}
