<?php

namespace App\Controller;

use App\Service\UrlService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

class UrlController extends AbstractController
{

    private UrlService $urlService;

    public function __construct(UrlService $urlService)
    {
        $this->urlService = $urlService;
    }

    /**
     * @Route("/url/shorten", name="shorten_url", methods={"POST"})
     */
    public function shorten(Request $request): Response
    {
        $fullUrl = $request->request->get('url');

        if (trim($fullUrl) === '') {
            throw new HttpException(400, 'Incorrect URL');
        }

        $shortUrl = $this->urlService->shortenUrl($fullUrl);

        return $this->render('url/shorten.html.twig', [
            'shortUrl' => $shortUrl,
        ]);
    }


    /**
     * @Route("/url/new", name="new_url", methods={"GET"})
     */
    public function new(): Response
    {
        return $this->render('url/new.html.twig', []);
    }
}
