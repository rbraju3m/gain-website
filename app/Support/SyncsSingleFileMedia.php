<?php

namespace App\Support;

use Illuminate\Http\Request;
use Spatie\MediaLibrary\HasMedia;

/**
 * Shared image sync for admin controllers that upload a single-file Spatie
 * media collection with an optional "remove_image" checkbox. Handles both the
 * remove flag and the replacement upload.
 */
trait SyncsSingleFileMedia
{
    protected function syncSingleFileMedia(HasMedia $model, Request $request, string $collection = 'image', string $field = 'image', string $removeField = 'remove_image'): void
    {
        if ($request->boolean($removeField)) {
            $model->clearMediaCollection($collection);
        }
        if ($request->hasFile($field)) {
            $model->clearMediaCollection($collection);
            $model->addMediaFromRequest($field)->toMediaCollection($collection);
        }
    }
}
