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
    public function homepage(Request $request)
    {
        $this->addNotifications($request);

        return $this->render('index.html.twig');
    }

    /**
     * @Route("/{req}", requirements={"req"=".+"})
     */
    public function fallback(Request $request)
    {
        $this->addNotifications($request);

        return $this->render(
            sprintf(
                '%1$s.%2$s',
                $request->getPathInfo(),
                'html.twig'
            )
        );
    }

    private function addNotifications(Request $request)
    {
        foreach (['success', 'report', 'warning', 'error'] as $key) {
            if ($request->get($key)) {
                $this->addFlash($key, $request->get($key));
            }
        }
    }
}
