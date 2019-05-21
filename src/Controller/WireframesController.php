<?php

namespace App\Controller;

use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WireframesController extends Controller
{
    private $data;

    /**
     * @Route("/")
     */
    public function homepage(Request $request)
    {
        $this->addNotifications($request);
        $this->addData();

        return $this->render(
            'index.html.twig',
            [
                'data' => $this->data,
            ]
        );
    }

    /**
     * @Route("/{req}", requirements={"req"=".+"})
     */
    public function fallback(Request $request)
    {
        $this->addNotifications($request);
        $this->addData();

        return $this->render(
            sprintf(
                '%1$s.%2$s',
                $request->getPathInfo(),
                'html.twig'
            ),
            [
                'data' => $this->data,
            ]
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

    private function addData()
    {
        $dataDirectory = __DIR__ . '/../../assets/data';
        $this->data = new \stdClass();

        if (!file_exists($dataDirectory)) {
            return;
        }

        $finder = new Finder();
        $finder
            ->files()
            ->name('*.json')
            ->in($dataDirectory);

        foreach ($finder as $file) {
            $key = str_replace('.json', '', $file->getFilename());
            $rawData = json_decode($file->getContents());

            $this->data->{$key} = $rawData;
        }
    }
}
