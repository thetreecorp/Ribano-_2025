<?php

namespace App\Http\Traits;

use App\Models\Language;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
trait Translatable
{
    public static function booted()
    {

        $lang = app()->getLocale();

        $minutes = config('constants.options.cache_time') ?? 60;

        if (Auth::getDefaultDriver() != 'admin') {
            $lang = app()->getLocale();
            

            // $languageId = Language::where('short_name', $lang)->first();
            

            $languageId = Cache::remember('language_id_' . $lang, $minutes, function () use ($lang, $minutes) {
                //return Language::where('short_name', $lang)->first();

                if (Cache::has('language_id_' . $lang)) {
                    return Cache::get('language_id_' . $lang);
                } else {
                    $language = Language::where('short_name', $lang)->first();
                    Cache::put('language_id_' . $lang, $language, now()->addMinutes($minutes));
                    return $language;
                }
            });
            
            

            

            
            // $defaultLang = Language::first();
            $defaultLang = Cache::remember('default_language', $minutes, function () use ($lang, $minutes) {
                if (Cache::has('default_language')) {
                    return Cache::get('default_language');
                } else {
                    $language = Language::first();
                    Cache::put('default_language', $language, now()->addMinutes($minutes));
                    return $language;
                }
            });

            

            static::addGlobalScope('language', function (Builder $builder) use ($languageId, $defaultLang) {
                if ($languageId) {
                    $builder->where('language_id', $languageId->id);
                } else {
                    $builder->where('language_id', $defaultLang->id);
                }
            });
        }
    }
}
