<?php

use Kirby\Cms\App;

App::plugin('moinframe/accessibility-check', [
    'options' => [
        'enabled' => true,
        // Which providers to render when the check is enabled. Available:
        // 'sa11y', 'editoria11y'.
        'providers' => ['sa11y'],
        'sa11y' => [
            // Which Sa11y release to load. 'latest' always uses the newest
            // release on the CDN; pin a version (e.g. '5.0.8') for stability.
            // See https://github.com/ryersondmp/sa11y/releases
            'version' => 'latest',
            // Load Sa11y from the jsDelivr CDN. Set to false to self-host.
            'cdn' => true,
            // Base URL of your self-hosted Sa11y `dist` folder, used when
            // `cdn` is false. No trailing slash, e.g. '/assets/sa11y'.
            'assets' => null
        ],
        'editoria11y' => [
            // Which Editoria11y release to load. 'latest' always uses the newest
            // release on the CDN; pin a version (e.g. '3.0.0') for stability.
            // See https://github.com/itmaybejj/editoria11y/releases
            'version' => 'latest',
            // Load Editoria11y from the jsDelivr CDN. Set to false to self-host.
            'cdn' => true,
            // Base URL of your self-hosted Editoria11y `dist` folder, used when
            // `cdn` is false. No trailing slash, e.g. '/assets/editoria11y'.
            'assets' => null
        ]
    ],
    'hooks' => [
        'page.render:after' => function (string $contentType, array $data, string $html, Kirby\Cms\Page $page) {
            if ($contentType !== 'html') {
                return $html;
            }

            $snippet = snippet('accessibility-check/accessibility-check', [], true);

            if (is_string($snippet) === false || $snippet === '') {
                return $html;
            }

            return str_replace('</head>', $snippet . '</head>', $html);
        }
    ],
    'api' => [
        'routes' => [
            [
                'pattern' => 'accessibility-check/status',
                'method' => 'GET',
                'action' => function () {
                    $session = kirby()->session();
                    $current = $session->get('accessibility-check-enabled', false);
                    return ['status' => 'success', 'mode' => $current];
                }
            ],
            [
                'pattern' => 'accessibility-check/toggle',
                'method' => 'POST',
                'action' => function () {
                    $session = kirby()->session();
                    $current = $session->get('accessibility-check-enabled', false);
                    $session->set('accessibility-check-enabled', !$current);
                    return ['status' => 'success', 'mode' => !$current];
                }
            ]
        ]
    ],
    'snippets' => [
        'accessibility-check/accessibility-check' => __DIR__ . '/snippets/accessibility-check.php',
        'accessibility-check/providers/sa11y' => __DIR__ . '/snippets/providers/sa11y.php',
        'accessibility-check/providers/editoria11y' => __DIR__ . '/snippets/providers/editoria11y.php'
    ],
    'translations' => [
        'en' => [
            "moinframe.accessibility-check.buttons.enable" => "Enable",
            "moinframe.accessibility-check.buttons.disable" => "Disable",
            "moinframe.accessibility-check.buttons.open" => "Open",
            "moinframe.accessibility-check.buttons.toggle" => "Check accessibility"
        ],
        'de' => [
            "moinframe.accessibility-check.buttons.enable" => "Aktivieren",
            "moinframe.accessibility-check.buttons.disable" => "Deaktivieren",
            "moinframe.accessibility-check.buttons.open" => "Öffnen",
            "moinframe.accessibility-check.buttons.toggle" => "Barrierefreiheit prüfen"
        ]
    ]
]);
