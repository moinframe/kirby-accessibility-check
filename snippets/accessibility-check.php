<?php
if (option('moinframe.accessibility-check.enabled') !== true) return;

if (kirby()->session()->get('accessibility-check-enabled', false) !== true) return;

// Render each configured provider. Validate against the known list so a typo
// in `providers` can never render an arbitrary snippet name.
$known = ['sa11y', 'editoria11y'];
$providers = (array) option('moinframe.accessibility-check.providers', ['sa11y']);

foreach ($providers as $provider) {
    if (in_array($provider, $known, true) === true) {
        snippet('accessibility-check/providers/' . $provider);
    }
}
