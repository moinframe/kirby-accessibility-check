# Kirby Accessibility Check

This plugin adds accessibility checking capabilities to your Kirby CMS powered website. With the panel button, editors can enable an accessibility overlay to easily spot issues in the frontend of your website. By default, the Accessibility quality assurance tool [Sa11y](https://github.com/ryersondmp/sa11y) is used and added via CDN. Additional providers such as [Editoria11y](https://github.com/itmaybejj/editoria11y) can be enabled via [configuration](#providers).

## Features

- Adds accessibility check button to panel
- Only active when editor chooses to enable it (uses session)
- Automatically includes required assets when active

![Plugin in action](kirby-accessibility-check.gif)

## Installation

There are three options to install the plugin.

### Download

Download and copy this repository to `/site/plugins/accessibility-check`.

### Git submodule

```bash
git submodule add https://github.com/moinframe/kirby-accessibility-check.git site/plugins/accessibility-check
```

### Composer

```bash
composer require moinframe/kirby-accessibility-check
```

## Setup

This plugin registers a new panel view button you can use in your page blueprints.

```yaml
# site/blueprints/pages/default.yml

buttons:
 # new button
 - accessibility-check
 # default buttons
 - preview
 - languages
 - settings
 - status

```

## Configuration

You can configure the plugin in your `site/config/config.php` file:

```php
return [
    // Enable/disable the plugin entirely
    'moinframe.accessibility-check.enabled' => true, // default: true

    // Which providers to render when the check is enabled.
    // Available: 'sa11y', 'editoria11y'
    'moinframe.accessibility-check.providers' => ['sa11y'], // default: ['sa11y']

    // Which Sa11y release to load ('latest' or a pinned version like '5.0.8')
    'moinframe.accessibility-check.sa11y.version' => 'latest', // default: 'latest'

    // Load Sa11y from the jsDelivr CDN. Set to false to self-host.
    'moinframe.accessibility-check.sa11y.cdn' => true, // default: true

    // When `cdn` is false, point this at your copy of Sa11y's `dist`
    // folder (no trailing slash). Required for self-hosting.
    'moinframe.accessibility-check.sa11y.assets' => '/assets/sa11y', // default: null

    'moinframe.accessibility-check.editoria11y.version' => 'latest', // default: 'latest'
    'moinframe.accessibility-check.editoria11y.cdn' => true,         // default: true
    'moinframe.accessibility-check.editoria11y.assets' => '/assets/editoria11y', // default: null
];
```

## Providers

The plugin can render one or more accessibility tools ("providers") when an editor
enables the check. Choose them with the `providers` option:

| Name          | Tool                                                    | Notes                              |
| ------------- | ------------------------------------------------------- | ---------------------------------- |
| `sa11y`       | [Sa11y](https://github.com/ryersondmp/sa11y)            | Default. WCAG checker overlay.     |
| `editoria11y` | [Editoria11y](https://github.com/itmaybejj/editoria11y) | Alternative editor-focused checker |


## Self-hosting Sa11y

To avoid the CDN, set `sa11y.cdn` to `false` and copy Sa11y's `dist`
folder somewhere public (e.g. `assets/sa11y/dist/...`), then point
`sa11y.assets` at it. The plugin expects the standard Sa11y layout below
the base URL:

```
<assets>/css/sa11y.min.css
<assets>/js/lang/<lang>.umd.js
<assets>/js/sa11y.umd.min.js
```

For full control over the markup, you can still override the whole snippet
at `site/snippets/accessibility-check/providers/sa11y.php`.

## Self-hosting Editoria11y

Same idea for Editoria11y: set `editoria11y.cdn` to `false` and point
`editoria11y.assets` at your copy of its `dist` folder. The expected layout is:

```
<assets>/css/editoria11y.min.css
<assets>/js/lang/<lang>.umd.js
<assets>/js/ed11y.umd.min.js
```

## License
MIT

## Credits
- [Justus Kraft](https://moinfra.me)
- Accessibility quality assurance tool [Sa11y](https://github.com/ryersondmp/sa11y)
- Accessibility checker [Editoria11y](https://github.com/itmaybejj/editoria11y)
