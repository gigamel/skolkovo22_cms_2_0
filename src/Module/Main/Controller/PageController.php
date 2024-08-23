<?php

declare(strict_types=1);

namespace Skolkovo22\Module\Main\Controller;

use Skolkovo22\Common\Http\Protocol\ClientMessageInterface;
use Skolkovo22\Common\Http\Protocol\ServerMessageInterface;
use Skolkovo22\Common\Http\Response;
use Skolkovo22\Http\AbstractController;

final class PageController extends AbstractController
{
    public function index(ClientMessageInterface $request): ServerMessageInterface
    {
        return new Response(
            '
                <!DOCTYPE html>
                <html lang="en">
                  <head>
                    <meta charset="UTF-8"/>
                    <title>Hello</title>
                  </head>
                  <body>
                    <h1>Welcome to CMS 2.0!</h1>
                    <p>We are here...</p>
                  </body>
                </html>
            '
        );
    }
}
