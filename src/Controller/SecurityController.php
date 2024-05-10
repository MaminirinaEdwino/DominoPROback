<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController extends AbstractController
{
    #[Route(path: '/api/login', name:'api_login', methods:['POST'])]
    public function login(){
        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUserIdentifier(),
            'roles'=> $user->getRoles(),
        ]);
    }

    #[Route('/api/logout', name: 'api_logout', methods: ['POST'])]
    public function logout()
    {

    }

    #[Route('/api/user/info', name: 'api_user_info', methods: ['GET'])]
    public function recupInfoUser()
    {
        $user = $this->getUser();
        return $this->json([
            'username' => $user->getUserIdentifier(),
            'status' => 'connectée',
            'roles' => $user->getRoles()
        ], 200);
    }
}
