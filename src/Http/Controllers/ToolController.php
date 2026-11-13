<?php

namespace WebBestPractice\BruceChat\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use WebBestPractice\BruceChat\Contracts\ToolHandler;

class ToolController extends Controller
{
    public function __invoke(Request $request, string $tool): JsonResponse
    {
        $tools = config('bruce-chat.tools', []);

        if (! array_key_exists($tool, $tools) || ! ($tools[$tool]['enabled'] ?? false)) {
            return response()->json([
                'message' => 'Tool not found or disabled.',
            ], 404);
        }

        $definition = $tools[$tool];
        $rules = $this->validationRules($definition['fields'] ?? []);

        $validated = Validator::make($request->all(), $rules)->validate();

        $handlerClass = $definition['handler'] ?? null;

        if (! is_string($handlerClass) || ! is_subclass_of($handlerClass, ToolHandler::class)) {
            return response()->json([
                'message' => 'Tool handler is not configured correctly.',
            ], 500);
        }

        /** @var ToolHandler $handler */
        $handler = app($handlerClass);

        $result = $handler->handle($tool, $validated, $request);

        return response()->json($result);
    }

    /**
     * @param  array<string, array{type?: string, required?: bool}>  $fields
     * @return array<string, list<string>>
     */
    protected function validationRules(array $fields): array
    {
        $rules = [];

        foreach ($fields as $name => $field) {
            $fieldRules = [];

            if (($field['required'] ?? false) === true) {
                $fieldRules[] = 'required';
            } else {
                $fieldRules[] = 'nullable';
            }

            $type = $field['type'] ?? 'string';

            $fieldRules[] = match ($type) {
                'email' => 'email',
                'integer' => 'integer',
                'boolean' => 'boolean',
                'array' => 'array',
                default => 'string',
            };

            if ($type === 'string' || $type === 'email') {
                $fieldRules[] = 'max:5000';
            }

            $rules[$name] = $fieldRules;
        }

        return $rules;
    }
}
