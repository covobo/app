<?php

declare(strict_types=1);

namespace SunFinanceGroup\Notificator\AppBundle\Notification;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;
use SunFinanceGroup\Notificator\NotificationService\Message;
use SunFinanceGroup\Notificator\NotificationService\TransportInterface;

final class GotifyTransport implements TransportInterface
{
    private const URI_TEMPLATE = '/message?token=%s';
    private string $token;
    private ClientInterface $guzzle;

    public function __construct(string $token, ClientInterface $guzzle)
    {
        $this->token = $token;
        $this->guzzle = $guzzle;
    }

    public function send(Message $message): void
    {
        $this->guzzle->request(
            'POST',
            sprintf(self::URI_TEMPLATE, $this->token),
            [
                RequestOptions::FORM_PARAMS => [
                    'title' => $message->getRecipient(),
                    'message' => $message->getBody()
                ]
            ]
        );
    }
}