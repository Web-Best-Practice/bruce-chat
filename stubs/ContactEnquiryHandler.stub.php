<?php

namespace App\Bruce;

use Illuminate\Http\Request;
use WebBestPractice\BruceChat\Contracts\ToolHandler;

class ContactEnquiryHandler implements ToolHandler
{
    public function handle(string $tool, array $payload, Request $request): array
    {
        // Enquiry::create([
        //     'name' => $payload['name'],
        //     'email' => $payload['email'],
        //     'phone' => $payload['phone'] ?? null,
        //     'message' => $payload['message'],
        //     'source' => 'bruce_chat',
        // ]);

        return [
            'ok' => true,
            'message' => 'Enquiry saved.',
        ];
    }
}
