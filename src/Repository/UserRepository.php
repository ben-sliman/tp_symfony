<?php
namespace App\Repository;

use App\Entity\User;
use App\Entity\Preference;
use App\Repository\RoleRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    private $em;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(ManagerRegistry $registry, UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct($registry, User::class);
        $this->em = $this->getEntityManager();
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * Crée et persiste un nouvel utilisateur à partir d'un tableau de données.
     *
     * Le tableau $data doit contenir :
     * - email, nom, prenom, password
     * - roles : tableau de noms (ex. ["ROLE_USER", "ROLE_ADMIN"])
     * - preference (optionnel) : tableau avec 'langue', 'theme' et 'notifications'
     *
     * @param array $data
     * @param RoleRepository $roleRepository
     * @return User
     */
    public function createUser(array $data, RoleRepository $roleRepository): User
    {
        $user = new User();
        $user->setEmail($data['email']);
        $user->setNom($data['nom']);
        $user->setPrenom($data['prenom']);

        // Hachage du mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Ajout des rôles via leurs noms (retrouvés avec le RoleRepository)
        if (isset($data['roles']) && is_array($data['roles'])) {
            foreach ($data['roles'] as $roleName) {
                $role = $roleRepository->findOneBy(['nom' => $roleName]);
                if ($role) {
                    $user->addRole($role);
                }
            }
        }

        // Création de la préférence utilisateur, si fournie
        if (isset($data['preference'])) {
            $prefData = $data['preference'];
            $preference = new Preference();
            $preference->setLangue($prefData['langue'] ?? 'en')
                       ->setTheme($prefData['theme'] ?? 'light')
                       ->setNotifications($prefData['notifications'] ?? false);
            $user->setPreference($preference);
        }

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * Met à jour un utilisateur existant à partir d'un tableau de données.
     *
     * @param User $user L'utilisateur à mettre à jour.
     * @param array $data Les données de mise à jour (email, nom, prenom, password, roles, preference)
     * @param RoleRepository $roleRepository
     *
     * @return User
     */
    public function updateUser(User $user, array $data, RoleRepository $roleRepository): User
    {
        if (isset($data['email'])) {
            $user->setEmail($data['email']);
        }
        if (isset($data['nom'])) {
            $user->setNom($data['nom']);
        }
        if (isset($data['prenom'])) {
            $user->setPrenom($data['prenom']);
        }
        if (isset($data['password'])) {
            $hashedPassword = $this->passwordHasher->hashPassword($user, $data['password']);
            $user->setPassword($hashedPassword);
        }

        // Mise à jour des rôles : suppression de l'ancienne collection et ajout des nouveaux rôles par leur nom
        if (isset($data['roles']) && is_array($data['roles'])) {
            $user->getRolesCollection()->clear();
            foreach ($data['roles'] as $roleName) {
                $role = $roleRepository->findOneBy(['nom' => $roleName]);
                if ($role) {
                    $user->addRole($role);
                }
            }
        }

        // Mise à jour de la préférence utilisateur (création si elle n'existe pas)
        if (isset($data['preference'])) {
            $prefData = $data['preference'];
            $preference = $user->getPreference() ?? new Preference();
            $preference->setLangue($prefData['langue'] ?? ($preference->getLangue() ?? 'en'))
                       ->setTheme($prefData['theme'] ?? ($preference->getTheme() ?? 'light'))
                       ->setNotifications($prefData['notifications'] ?? ($preference->getNotifications() ?? false));
            $user->setPreference($preference);
        }

        $this->em->flush();

        return $user;
    }
}
