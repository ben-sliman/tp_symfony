<?php
namespace App\Repository;

use App\Entity\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Role>
 */
class RoleRepository extends ServiceEntityRepository
{
    private $em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
        $this->em = $this->getEntityManager();
    }

    /**
     * Crée et persiste un rôle à partir d'un tableau de données.
     *
     * Le tableau $data doit contenir :
     * - nom : le nom du rôle (par exemple "ROLE_USER" ou "ROLE_ADMIN")
     *
     * @param array $data
     * @return Role
     */
    public function createRole(array $data): Role
    {
        $role = new Role();
        $role->setNom($data['nom']);

        $this->em->persist($role);
        $this->em->flush();

        return $role;
    }

    /**
     * Met à jour un rôle existant à partir d'un tableau de données.
     *
     * @param Role $role L'entité Role à mettre à jour.
     * @param array $data Les données de mise à jour (par exemple, 'nom')
     *
     * @return Role
     */
    public function updateRole(Role $role, array $data): Role
    {
        if (isset($data['nom'])) {
            $role->setNom($data['nom']);
        }

        $this->em->flush();

        return $role;
    }
}
