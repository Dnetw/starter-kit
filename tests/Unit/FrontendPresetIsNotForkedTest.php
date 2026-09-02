<?php

/**
 * The app's Vite entry must load dnetw/core's shared frontend preset, and must
 * not carry its own copy of anything the preset already ships.
 *
 * `<x-dnetw::map>` renders `x-data="dnetwMap(...)"`, and Alpine resolves that
 * name the moment it walks the DOM. The factory lives in core's
 * `map-component.js`, which `preset.js` pulls into the main bundle for exactly
 * that reason — the lazily injected `maplibre.js` entry executes too late on a
 * cold cache, and the page dies with "dnetwMap is not defined". Nothing about
 * that failure is visible server-side: the Blade renders, the payload is
 * correct, and a reload with a warm cache hides it again.
 *
 * This app kept a `resources/js/passkeys.js` byte-identical to core's. Nothing
 * loaded it — Vite builds core's copy — but a stale duplicate that looks
 * authoritative is how the fork starts. These two assertions are the alarm on
 * that, and on dropping the preset import.
 *
 * Deliberately a Unit test: it reads files only, so it needs no database.
 */
function repositoryPath(string $relative): string
{
    return dirname(__DIR__, 2).'/'.$relative;
}

it('imports the shared preset from dnetw/core rather than reimplementing it', function () {
    $entry = repositoryPath('resources/js/app.js');

    expect($entry)->toBeReadableFile();

    $imported = str_contains((string) file_get_contents($entry), 'vendor/dnetw/core/resources/js/preset.js');

    expect($imported)->toBeTrue(
        'resources/js/app.js does not import core\'s preset.js, so the dnetwMap factory never reaches the main bundle and every <x-dnetw::map> is a cold-cache race.',
    );
});

it('keeps no local fork of a module dnetw/core already ships', function () {
    // app.js is each app's own Vite entry; core ships one for its own build.
    // Every other shared name means the app copied a file it should import.
    $shared = collect(glob(repositoryPath('vendor/dnetw/core/resources/js/*.js')))
        ->map(fn (string $path): string => basename($path))
        ->reject(fn (string $name): bool => $name === 'app.js');

    $local = collect(glob(repositoryPath('resources/js/*.js')))
        ->map(fn (string $path): string => basename($path));

    expect($shared)->not->toBeEmpty('core ships no JS at all, which cannot be right');

    $forked = $local->intersect($shared)->values()->all();

    expect($forked)->toBe(
        [],
        'resources/js/'.implode(', resources/js/', $forked).' shadows a file dnetw/core already ships. Delete the copy and let preset.js pull core\'s in, or core\'s fixes will keep skipping this app.',
    );
});
