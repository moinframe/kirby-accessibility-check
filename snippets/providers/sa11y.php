<?php
$panelLanguage = kirby()->user()?->language() ?? 'en';

// Map panel languages to sa11y languages
$langMap = [
    'bg' => 'bg',
    'cs' => 'cs',
    'da' => 'da',
    'de' => 'de',
    'el' => 'el',
    'en' => 'en',
    'es_419' => 'es',
    'es_ES' => 'es',
    'fi' => 'fi',
    'fr' => 'fr',
    'hu' => 'hu',
    'id' => 'id',
    'it' => 'it',
    'ko' => 'ko',
    'lt' => 'lt',
    'nb' => 'nb',
    'nl' => 'nl',
    'pl' => 'pl',
    'pt_BR' => 'ptBR',
    'pt_PT' => 'ptPT',
    'ro' => 'ro',
    'sk' => 'sk',
    'sv_SE' => 'sv',
    'tr' => 'tr'
];

$lang = $langMap[$panelLanguage] ?? 'en';

// Resolve where Sa11y's `dist` files are loaded from.
$useCdn = option('moinframe.accessibility-check.sa11y.cdn', true) !== false;
$version = option('moinframe.accessibility-check.sa11y.version', 'latest');
$assets = option('moinframe.accessibility-check.sa11y.assets');

if ($useCdn === true) {
    // jsDelivr CDN, pinned to the configured release.
    $base = 'https://cdn.jsdelivr.net/gh/ryersondmp/sa11y@' . $version . '/dist';
} else {
    // Self-hosted: point `sa11y.assets` at your copy of Sa11y's `dist` folder.
    $base = rtrim((string) $assets, '/');

    if ($base === '') {
        return; // self-hosting is enabled but no `sa11y.assets` path is set
    }
}

?>

<link rel="stylesheet" href="<?= $base ?>/css/sa11y.min.css" />
<script src="<?= $base ?>/js/lang/<?= $lang ?>.umd.js"></script>
<script src="<?= $base ?>/js/sa11y.umd.min.js"></script>
<script>
    Sa11y.Lang.addI18n(Sa11yLang<?= ucfirst($lang) ?>.strings);
    const sa11y = new Sa11y.Sa11y({
        checkRoot: "body",
    });
</script>