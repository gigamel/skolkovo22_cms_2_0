<?php

declare(strict_types=1);

namespace Skolkovo22\Module\Authentification\Controller;

use Skolkovo22\Common\Http\Protocol\ClientMessageInterface;
use Skolkovo22\Common\Http\Protocol\ServerMessageInterface;
use Skolkovo22\Common\Http\Response;
use Skolkovo22\Http\AbstractSecureController;

final class LogoutController extends AbstractSecureController
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
                    <button>Logout</button>
                  </body>
                </html>
            '
        );
    }
}
