<?php

declare(strict_types=1);

namespace Skolkovo22\Controller;

use Skolkovo22\Common\Http\AbstractController;
use Skolkovo22\Common\Http\Protocol\ClientMessageInterface;
use Skolkovo22\Common\Http\Protocol\ServerMessageInterface;
use Skolkovo22\Common\Http\Response;

final class DefaultController extends AbstractController
{
    public function __construct(private readonly \Skolkovo22\Common\Log\LoggerInterface $logger)
    {
    }
    
    public function index(ClientMessageInterface $request): ServerMessageInterface
    {
        // $this->logger->info(sprintf('Hello from %s', $this::class));
        return new Response('<h1>Welcome to CMS 2.0!</h1>');
    }
}
