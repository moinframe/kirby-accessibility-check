<?php
$panelLanguage = kirby()->user()?->language() ?? 'en';

// Map panel languages to Editoria11y language packs.
// Codes without an Editoria11y translation fall back to English below.
$langMap = [
    'da' => 'da',
    'de' => 'de',
    'el' => 'el',
    'en' => 'en',
    'es_419' => 'es',
    'es_ES' => 'es',
    'fr' => 'fr',
    'hu' => 'hu',
    'it' => 'it',
    'nb' => 'nb',
    'nl' => 'nl',
    'pl' => 'pl',
    'pt_BR' => 'pt-br',
    'pt_PT' => 'pt-pt',
    'sv_SE' => 'sv'
];

$lang = $langMap[$panelLanguage] ?? 'en';

// Each language pack registers a global named `Ed11yLang<Ucfirst(code)>`
// (e.g. `de` -> `Ed11yLangDe`, `pt-br` -> `Ed11yLangPt-br`). Hyphenated names
// aren't valid identifiers, so the global is read via bracket notation, and the
// translation the checker expects lives on its `.lang` property.
$langGlobal = 'Ed11yLang' . ucfirst($lang);

// Resolve where Editoria11y's `dist` files are loaded from.
$useCdn = option('moinframe.accessibility-check.editoria11y.cdn', true) !== false;
$version = option('moinframe.accessibility-check.editoria11y.version', 'latest');
$assets = option('moinframe.accessibility-check.editoria11y.assets');

if ($useCdn === true) {
    // jsDelivr CDN, pinned to the configured release.
    $base = 'https://cdn.jsdelivr.net/gh/itmaybejj/editoria11y@' . $version . '/dist';
} else {
    // Self-hosted: point `editoria11y.assets` at your copy of the `dist` folder.
    $base = rtrim((string) $assets, '/');

    if ($base === '') {
        return; // self-hosting is enabled but no `editoria11y.assets` path is set
    }
}

?>

<link rel="stylesheet" href="<?= $base ?>/css/editoria11y.min.css" />
<script src="<?= $base ?>/js/lang/<?= $lang ?>.umd.js"></script>
<script src="<?= $base ?>/js/ed11y.umd.min.js"></script>
<script>
    new Ed11y.Ed11y({
        checkRoot: "body",
        lang: window["<?= $langGlobal ?>"].lang,
    });
</script>
