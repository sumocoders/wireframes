<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WireframesController extends Controller
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/{req}", requirements={"req"=".+"})
     */
    public function fallback(Request $request)
    {
        return $this->render(
            sprintf(
                '%1$s.%2$s',
                $request->getPathInfo(),
                'html.twig'
            )
        );
    }
}
