# Bruce Chat

Laravel bridge package for the [Bruce](https://github.com/Web-Best-Practice/bruce) AI chat widget.

It provides:

- Blade helper / component to embed the chat widget
- Capabilities API so Bruce can discover enabled tools
- Tool invoke API so Bruce can submit enquiries into the host app

**Repository:** https://github.com/Web-Best-Practice/bruce-chat

## Install

### Add a custom repository

```bash
composer config repositories.bruce-chat vcs https://github.com/Web-Best-Practice/bruce-chat
```

### Install the package

```bash
composer require web-best-practice/bruce-chat
php artisan vendor:publish --tag=bruce-chat-config
```

## Environment

```env
BRUCE_CHAT_ENABLED=true
BRUCE_CHAT_API_URL=https://bruce.test
BRUCE_CHAT_CLIENT_HASH=your-client-hash-from-bruce
BRUCE_CHAT_SECRET=shared-secret-with-bruce
```

## Embed the widget

### Script only (no package required)

Chat works with a single script tag. Use this when Composer/package install is not possible:

```html
<script
  src="https://your-bruce-host/chat.js"
  data-client="CLIENT_HASH_FROM_BRUCE"
  data-api="https://your-bruce-host"
  defer
></script>
```

Bruce’s client Chat settings screen also shows a ready-to-copy snippet.

Without this package, visitors can still chat. Enquiry tools that write into the host site are unavailable until the package (or equivalent capabilities API) is installed.

### With this package (Laravel)

In a Blade layout:

```blade
@bruceChat
```

Or as a component:

```blade
<x-bruce-chat />
```

For relative widget placement, put the tag where the button should appear in the page.

## Configure tools

Edit `config/bruce-chat.php`:

```php
'tools' => [
    'contact_enquiry' => [
        'enabled' => true,
        'name' => 'Submit contact enquiry',
        'description' => 'Send a general contact enquiry to the business.',
        'fields' => [
            'name' => ['type' => 'string', 'required' => true],
            'email' => ['type' => 'email', 'required' => true],
            'message' => ['type' => 'string', 'required' => true],
        ],
        'handler' => App\Bruce\ContactEnquiryHandler::class,
    ],
],
```

Create a handler implementing `WebBestPractice\BruceChat\Contracts\ToolHandler`:

```php
namespace App\Bruce;

use Illuminate\Http\Request;
use WebBestPractice\BruceChat\Contracts\ToolHandler;

class ContactEnquiryHandler implements ToolHandler
{
    public function handle(string $tool, array $payload, Request $request): array
    {
        // e.g. Enquiry::create($payload);

        return [
            'ok' => true,
            'message' => 'Enquiry saved.',
        ];
    }
}
```

## API

All routes are prefixed with `api/bruce` by default and require auth:

- `Authorization: Bearer {BRUCE_CHAT_SECRET}`, or
- `X-Bruce-Secret: {BRUCE_CHAT_SECRET}`

### Discover tools

```http
GET /api/bruce/capabilities
```

### Invoke a tool

```http
POST /api/bruce/tools/contact_enquiry
Content-Type: application/json

{
  "name": "Jane Doe",
  "email": "jane@example.com",
  "message": "Please call me back"
}
```

## Local path repository (optional)

While developing next to Bruce:

```json
{
  "repositories": [
    {
      "type": "path",
      "url": "../bruce-chat",
      "options": { "symlink": true }
    }
  ]
}
```

```bash
composer require web-best-practice/bruce-chat:@dev
```
