{{--
    Copyright (c) ppy Pty Ltd <contact@ppy.sh>. Licensed under the GNU Affero General Public License v3.0.
    See the LICENCE file in the repository root for full licence text.
--}}
@if ($page->isVisible() && $page->locale !== $locale)
    <div class="wiki-notice">
        {{ trans('wiki.show.fallback_translation', ['language' => locale_name($locale)]) }}
    </div>
@endif

@if ($page->isLegalTranslation())
    <div class="wiki-notice wiki-notice--important">
        {!! trans('wiki.show.translation.legal', [
            'default' => '<a href="'.e(wiki_url($page->path, config('app.fallback_locale'))).'">'.e(trans('wiki.show.translation.default')).'</a>',
        ]) !!}
    </div>
@endif

@if ($page->isOutdated())
    <div class="wiki-notice">
        @if ($page->isTranslation())
            {!! trans('wiki.show.translation.outdated', [
                'default' => '<a href="'.e(wiki_url($page->path, config('app.fallback_locale'))).'">'.e(trans('wiki.show.translation.default')).'</a>',
            ]) !!}
        @else
            {{ trans('wiki.show.incomplete_or_outdated') }}
        @endif
    </div>
@elseif ($page->needsCleanup())
    <div class="wiki-notice">
        {{ trans('wiki.show.needs_cleanup_or_rewrite') }}
    </div>
@endif
