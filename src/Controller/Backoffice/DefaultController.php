<?php

namespace App\Controller\Backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/administration', name: 'app_backoffice_home')]
    public function index(): Response
    {
        return $this->render('backoffice/default/index.html.twig');
    }
}
