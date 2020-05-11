<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MosaicController extends AbstractController
{
    /**
     * @Route("/mosaic", name="mosaic")
     */
    public function index()
    {
        return $this->render('mosaic/index.html.twig');
    }
}
