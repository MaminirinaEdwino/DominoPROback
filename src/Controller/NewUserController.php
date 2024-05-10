<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class NewUserController extends AbstractController
{
    public function __invoke($data, UserPasswordHasherInterface $hasher)
    {
        $user = $data;
        $mdp = $user->getPassword();
        $user->setPassword($hasher->hashPassword($user, $mdp));
        return $user;
    }
}
