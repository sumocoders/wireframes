<?php

namespace App\Controller;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DocumentationController extends Controller
{
    /**
     * @Route("/_docs")
     */
    public function homepage(Request $request)
    {
        return $this->render(
            '_docs/index.html.twig',
            [
                'menu' => $this->buildMenu($request->getPathInfo()),
                'pendingQuestions' => $this->findPendingQuestions(),
                'todos' => $this->findTodos(),
            ]
        );
    }

    /**
     * @Route("/_docs/{req}", requirements={"req"=".+"})
     */
    public function fallback(Request $request)
    {
        return $this->render(
            sprintf(
                '%1$s.%2$s',
                $request->getPathInfo(),
                'html.twig'
            ),
            [
                'menu' => $this->buildMenu($request->getPathInfo()),
            ]
        );
    }

    private function loopDocs(callable $callback)
    {
        $templatePath = $this->container->getParameter('kernel.project_dir') . '/templates/_docs';

        $finder = new Finder();
        $finder->files()->in($templatePath);

        foreach ($finder as $file) {
            $callback(
                file_get_contents(
                    $file->getRealPath()
                ),
                $file
            );
        }
    }

    private function buildMenu(string $currentPath): string
    {
        $navigation = [];
        $this->loopDocs(
            function ($content, $file) use (&$navigation) {
                $link = str_replace('.html.twig', '', $file->getRelativePathname());

                preg_match_all('|<h1.*id="(.*)".*>(.*)</h1>|iUms', $content, $matches);

                foreach ($matches[0] as $index => $match) {
                    if ($matches[1][$index] !== '') {
                        $link .= '#' . $matches[1][$index];
                    }

                    $navigation[] = [
                        'label' => $matches[2][$index],
                        'link' => $link,
                        'id' => $matches[1][$index],
                        'file' => $file
                    ];
                }
            }
        );

        usort(
            $navigation,
            function ($e1, $e2) {
                return strcmp($e1['file']->getBasename(), $e2['file']->getBasename());
            }
        );

        $html = '<ul id="docs-navigation" class="nav flex-column">' . "\n";
        $html .= '<li class="nav-item" id="menu__intro">' . "\n";
        $html .= '  <a class="nav-link" href="/_docs#intro">Intro</a>' . "\n";
        $html .= '</li>' . "\n";

        foreach ($navigation as $navItem) {
            $html .= '  <li class="nav-item" id="menu__' . $navItem['id'] . '">' . "\n";
            $html .= '      <a class="nav-link" href="/_docs/' . $navItem['link'] . '">';
            $html .= '          ' . $navItem['label'];
            $html .= '      </a>' . "\n";
            $html .= '  </li>' . "\n";
        }

        $html .= '</ul>' . "\n";

        return $html;
    }

    private function findPendingQuestions(): array
    {
        $questions = [];
        $this->loopDocs(
            function ($content) use (&$questions) {
                preg_match_all('|<question>(.*)</question>|iUms', $content, $matches);

                foreach ($matches[1] as $question) {
                    // skip questions with an answer
                    if (substr_count($question, '<answer>') > 0) {
                        continue;
                    }

                    $questions[] = str_replace(
                        ["\n", "\t"],
                        '',
                        $question
                    );
                }
            }
        );

        return $questions;
    }

    private function findTodos(): array
    {
        $todos = [];
        $this->loopDocs(
            function ($content) use (&$todos) {
                preg_match_all('|<todo>(.*)</todo>|iUms', $content, $matches);

                foreach ($matches[1] as $todo) {
                    $todos[] = str_replace(
                        ["\n", "\t"],
                        '',
                        $todo
                    );
                }
            }
        );

        return $todos;
    }
}
