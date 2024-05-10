<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class MeController extends AbstractController
{
    public function __construct(private Security $security)
    {
        
    }
    public function __invoke()
    {
        return $this->security->getUser();
    }
}
