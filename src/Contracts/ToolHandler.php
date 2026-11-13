<?php

namespace WebBestPractice\BruceChat\Contracts;

use Illuminate\Http\Request;

interface ToolHandler
{
    /**
     * Handle an incoming tool invocation from Bruce.
     *
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    public function handle(string $tool, array $payload, Request $request): array;
}
