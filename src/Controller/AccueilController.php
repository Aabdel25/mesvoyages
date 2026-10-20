<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Description of AccueilController
 *
 * @author akhal
 */
class AccueilController extends AbstractController{
    
    #[Route('/', name: 'accueil')]
    public function index(): Response{
        return $this->render("pages/accueil.html.twig");
        
    }
}
