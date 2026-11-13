<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Bruce API / Widget
    |--------------------------------------------------------------------------
    */

    'enabled' => env('BRUCE_CHAT_ENABLED', true),

    'api_url' => env('BRUCE_CHAT_API_URL', 'https://bruce.test'),

    'client_hash' => env('BRUCE_CHAT_CLIENT_HASH'),

    'secret' => env('BRUCE_CHAT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Route prefix
    |--------------------------------------------------------------------------
    */

    'route_prefix' => env('BRUCE_CHAT_ROUTE_PREFIX', 'api/bruce'),

    'middleware' => ['api'],

    /*
    |--------------------------------------------------------------------------
    | Available tools
    |--------------------------------------------------------------------------
    |
    | Define the tools this website exposes to the Bruce chat agent.
    | Only enabled tools are returned by GET /capabilities and callable
    | via POST /tools/{tool}.
    |
    | handler: fully-qualified class implementing
    | WebBestPractice\BruceChat\Contracts\ToolHandler
    |
    */

    'tools' => [

        'contact_enquiry' => [
            'enabled' => true,
            'name' => 'Submit contact enquiry',
            'description' => 'Send a general contact enquiry to the business.',
            'fields' => [
                'name' => ['type' => 'string', 'required' => true],
                'email' => ['type' => 'email', 'required' => true],
                'phone' => ['type' => 'string', 'required' => false],
                'message' => ['type' => 'string', 'required' => true],
            ],
            'handler' => WebBestPractice\BruceChat\Tools\LogToolHandler::class,
        ],

        'product_enquiry' => [
            'enabled' => false,
            'name' => 'Enquire about a product',
            'description' => 'Send a product-specific enquiry to the business.',
            'fields' => [
                'name' => ['type' => 'string', 'required' => true],
                'email' => ['type' => 'email', 'required' => true],
                'product_sku' => ['type' => 'string', 'required' => true],
                'message' => ['type' => 'string', 'required' => true],
            ],
            'handler' => WebBestPractice\BruceChat\Tools\LogToolHandler::class,
        ],

    ],

];
