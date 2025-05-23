<?php
namespace App\Controller;

use App\Entity\Role;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\{
    JsonResponse,
    Request,
    Response
};
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/roles")]
class RoleController extends AbstractController
{
    private EntityManagerInterface $em;
    private RoleRepository $roleRepository;
    
    public function __construct(
        EntityManagerInterface $em,
        RoleRepository $roleRepository
    ) {
        $this->em = $em;
        $this->roleRepository = $roleRepository;
    }
    
    // GET /roles : liste tous les rôles
    #[Route("", name:"role_list", methods:["GET"])]
    public function listRoles(): JsonResponse
    {
        $roles = $this->roleRepository->findAll();
        $data = [];
        foreach ($roles as $role) {
            $data[] = [
                'id'  => $role->getId(),
                'nom' => $role->getNom(),
            ];
        }
        return $this->json($data);
    }
    
    // GET /roles/{id} : affiche les détails d’un rôle
    #[Route("/{id}", name:"role_show", methods:["GET"])]
    public function showRole(int $id): JsonResponse
    {
        $role = $this->roleRepository->find($id);
        if (!$role) {
            return $this->json(['message' => 'Role not found'], Response::HTTP_NOT_FOUND);
        }
        $data = [
            'id'  => $role->getId(),
            'nom' => $role->getNom(),
        ];
        return $this->json($data);
    }
    
    // POST /roles : Crée un rôle via le repository
    #[Route("", name:"role_create", methods:["POST"])]
    public function createRole(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!$data || !isset($data['nom'])) {
            return $this->json(['message' => 'Invalid data'], Response::HTTP_BAD_REQUEST);
        }
        // La logique de création est déléguée au repository.
        $role = $this->roleRepository->createRole($data);
        return $this->json(['message' => 'Role created', 'id' => $role->getId()], Response::HTTP_CREATED);
    }
    
    // (Optionnel) PUT /roles/{id} : Met à jour un rôle via le repository
    #[Route("/{id}", name:"role_update", methods:["PUT"])]
    public function updateRole(Request $request, int $id): JsonResponse
    {
        $role = $this->roleRepository->find($id);
        if (!$role) {
            return $this->json(['message' => 'Role not found'], Response::HTTP_NOT_FOUND);
        }
        $data = json_decode($request->getContent(), true);
        if (!$data) {
            return $this->json(['message' => 'Invalid data'], Response::HTTP_BAD_REQUEST);
        }
        $role = $this->roleRepository->updateRole($role, $data);
        return $this->json(['message' => 'Role updated']);
    }
    
    // (Optionnel) DELETE /roles/{id} : Supprime un rôle
    #[Route("/{id}", name:"role_delete", methods:["DELETE"])]
    public function deleteRole(int $id): JsonResponse
    {
        $role = $this->roleRepository->find($id);
        if (!$role) {
            return $this->json(['message' => 'Role not found'], Response::HTTP_NOT_FOUND);
        }
        $this->em->remove($role);
        $this->em->flush();
        return $this->json(['message' => 'Role deleted']);
    }
}
