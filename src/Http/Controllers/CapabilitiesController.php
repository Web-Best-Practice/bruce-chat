<?php

namespace WebBestPractice\BruceChat\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class CapabilitiesController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $tools = collect(config('bruce-chat.tools', []))
            ->filter(fn (array $tool) => ($tool['enabled'] ?? false) === true)
            ->map(function (array $tool, string $id) {
                return [
                    'id' => $id,
                    'name' => $tool['name'] ?? $id,
                    'description' => $tool['description'] ?? '',
                    'fields' => $tool['fields'] ?? [],
                    'endpoint' => url(trim(config('bruce-chat.route_prefix'), '/').'/tools/'.$id),
                ];
            })
            ->values()
            ->all();

        return response()->json([
            'client_hash' => config('bruce-chat.client_hash'),
            'tools' => $tools,
        ]);
    }
}
