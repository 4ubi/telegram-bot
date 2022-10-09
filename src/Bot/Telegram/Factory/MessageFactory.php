<?php

namespace App\Bot\Telegram\Factory;

use App\Bot\Telegram\Model\Message;

class MessageFactory
{
    public function __construct(private BodyMessageFactory $bodyMessageFactory)
    {
    }

    public function createMessageFromResponse(array $data): ?Message
    {
        if (empty($data['message'])) {
            return null;
        }

        $messageData = $data['message'];

        return new Message(
            $messageData['message_id'] ?? time(),
            $this->bodyMessageFactory->createBodyMessageFromResponse($messageData),
            $messageData['date'],
            ChatFactory::createChatFromResponse($messageData['chat']),
            UserFactory::createUserFromResponse($messageData['from'])
        );
    }

}