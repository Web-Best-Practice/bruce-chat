<?php

namespace WebBestPractice\BruceChat\Tools;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use WebBestPractice\BruceChat\Contracts\ToolHandler;

class LogToolHandler implements ToolHandler
{
    /**
     * Default handler that logs the payload.
     * Replace with your own handler in config/bruce-chat.php.
     *
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    public function handle(string $tool, array $payload, Request $request): array
    {
        Log::info('Bruce chat tool invoked', [
            'tool' => $tool,
            'payload' => $payload,
        ]);

        return [
            'ok' => true,
            'tool' => $tool,
            'message' => 'Enquiry received.',
        ];
    }
}
