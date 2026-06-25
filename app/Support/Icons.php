<?php

namespace App\Support;

/**
 * Lightweight icon registry used by Impact stats, Achievements and MVV cards.
 * Each entry returns the inner SVG markup for a 24x24 viewBox. The chosen key
 * is stored on the model; admins pick from a dropdown rather than pasting SVG.
 */
class Icons
{
    /** key => [label for admin dropdown, inner svg markup] */
    public const LIBRARY = [
        // Stroke-style (used by Achievements + Impact)
        'people'    => ['People',         '<path d="M7 8a3 3 0 1 1 6 0 3 3 0 0 1-6 0Zm-4 9a4 4 0 0 1 8 0v1H3v-1Zm10 0a4 4 0 0 1 8 0v1h-8v-1Zm3-9a3 3 0 1 1 6 0 3 3 0 0 1-6 0Z" fill="currentColor"/>'],
        'food'      => ['Food / nutrition','<path d="M11 2a1 1 0 1 0-2 0v7H7V3a1 1 0 0 0-2 0v6.27A3 3 0 0 0 4 12v9a1 1 0 1 0 2 0v-7h2v7a1 1 0 1 0 2 0V12c0-.85-.4-1.62-1-2.12V2Zm6 0a1 1 0 0 0-1 1v10a3 3 0 0 0 2 2.83V21a1 1 0 1 0 2 0V3a1 1 0 0 0-3 0Z" fill="currentColor"/>'],
        'location'  => ['Location pin',   '<path d="M12 2a7 7 0 0 0-7 7c0 5.5 7 13 7 13s7-7.5 7-13a7 7 0 0 0-7-7Zm0 9.5a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5Z" fill="currentColor"/>'],
        'success'   => ['Shield + check', '<path d="M12 2 4 6v6c0 5 3.5 9.74 8 10 4.5-.26 8-5 8-10V6l-8-4Zm-1 14-4-4 1.4-1.4L11 13.2l4.6-4.6L17 10l-6 6Z" fill="currentColor"/>'],
        'book'      => ['Book / education','<path d="M4 4h6v16H4zM14 4h6v8h-6zM14 14h6v6h-6z" stroke="currentColor" stroke-width="2" fill="none" stroke-linejoin="round"/>'],
        'factory'   => ['Factory',        '<path d="M3 21V8l5 3V8l5 3V8l5 3v10H3Zm4-3h2v-3H7v3Zm5 0h2v-3h-2v3Zm5 0h2v-3h-2v3Z" stroke="currentColor" stroke-width="2" fill="none" stroke-linejoin="round"/>'],
        'trending'  => ['Trending up',    '<path d="M3 17 9 11l4 4 8-8M14 7h7v7" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>'],

        // MVV-specific
        'target'    => ['Target / mission','<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="5" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="1.6" fill="currentColor"/>'],
        'eye'       => ['Eye / vision',    '<path d="M1.5 12s4-7 10.5-7 10.5 7 10.5 7-4 7-10.5 7S1.5 12 1.5 12Z" fill="none" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" fill="currentColor"/>'],
        'star'      => ['Star / values',   '<path d="M12 2 14 8h6l-5 4 2 7-7-4-7 4 2-7-5-4h6z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>'],
    ];

    /** Inner SVG markup for the given key, or null. */
    public static function svg(?string $key): ?string
    {
        return self::LIBRARY[$key][1] ?? null;
    }

    /** key => label, for use in <select> options. */
    public static function options(): array
    {
        return array_map(fn ($row) => $row[0], self::LIBRARY);
    }

    public static function keys(): array
    {
        return array_keys(self::LIBRARY);
    }
}
