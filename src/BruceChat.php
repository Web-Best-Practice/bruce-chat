<?php

namespace WebBestPractice\BruceChat;

class BruceChat
{
    /**
     * Render the Bruce chat widget script tag.
     */
    public static function script(?string $clientHash = null, ?string $apiUrl = null): string
    {
        if (! config('bruce-chat.enabled')) {
            return '';
        }

        $clientHash ??= config('bruce-chat.client_hash');
        $apiUrl = rtrim($apiUrl ?? (string) config('bruce-chat.api_url'), '/');

        if (! $clientHash || ! $apiUrl) {
            return '';
        }

        $src = $apiUrl.'/chat.js';

        return sprintf(
            '<script src="%s" data-client="%s" data-api="%s" defer></script>',
            e($src),
            e($clientHash),
            e($apiUrl),
        );
    }
}
