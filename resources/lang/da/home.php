<?php

/**
 *    Copyright (c) ppy Pty Ltd <contact@ppy.sh>.
 *
 *    This file is part of osu!web. osu!web is distributed with the hope of
 *    attracting more community contributions to the core ecosystem of osu!.
 *
 *    osu!web is free software: you can redistribute it and/or modify
 *    it under the terms of the Affero GNU General Public License version 3
 *    as published by the Free Software Foundation.
 *
 *    osu!web is distributed WITHOUT ANY WARRANTY; without even the implied
 *    warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *    See the GNU Affero General Public License for more details.
 *
 *    You should have received a copy of the GNU Affero General Public License
 *    along with osu!web.  If not, see <http://www.gnu.org/licenses/>.
 */

return [
    'landing' => [
        'download' => 'Hent nu',
        'online' => '<strong>:players</strong> online i øjeblikket i <strong>:games</strong> spil',
        'peak' => 'Højeste antal, :count online brugere',
        'players' => '<strong>:count</strong> registrerede brugere',
        'title' => 'velkommen',
        'see_more_news' => 'se flere nyheder',

        'slogan' => [
            'main' => 'det aller-allerbedste, gratis rytmespil',
            'sub' => 'rytme er bare et klik væk',
        ],
    ],

    'search' => [
        'advanced_link' => 'Avanceret søgning',
        'button' => 'Søg',
        'empty_result' => 'Intet fundet!',
        'keyword_required' => 'Et søge-nøgleord behøves',
        'placeholder' => 'klik for at søge',
        'title' => 'Søg',

        'beatmapset' => [
            'login_required' => '',
            'more' => ':count flere beatmap søgeresultater',
            'more_simple' => 'Se flere beatmap søgeresultater',
            'title' => 'Beatmaps',
        ],

        'forum_post' => [
            'all' => 'Alle forumer',
            'link' => 'Søg i forumet',
            'login_required' => '',
            'more_simple' => 'Se flere forum-søgeresultater',
            'title' => 'Forum',

            'label' => [
                'forum' => 'søg i forummerne',
                'forum_children' => 'inkluder subforummer',
                'topic_id' => 'emne #',
                'username' => 'forfatter',
            ],
        ],

        'mode' => [
            'all' => 'alt',
            'beatmapset' => 'beatmap',
            'forum_post' => 'forum',
            'user' => 'bruger',
            'wiki_page' => 'wiki',
        ],

        'user' => [
            'login_required' => '',
            'more' => ':count flere spiller-søgeresultater',
            'more_simple' => 'Se flere spiller-søgeresultater',
            'more_hidden' => 'Spillersøgningen er begrænset til højest :max spillere. Prøv at søge igen.',
            'title' => 'Spillere',
        ],

        'wiki_page' => [
            'link' => 'Søg på wiki´et',
            'more_simple' => 'Se flere wiki-søgeresultater',
            'title' => 'Wiki',
        ],
    ],

    'download' => [
        'tagline' => "lad os få<br>dig i gang!",
        'action' => 'Download osu!',
        'os' => [
            'windows' => 'til Windows',
            'macos' => 'til macOS',
            'linux' => 'til Linux',
        ],
        'mirror' => 'mirror',
        'macos-fallback' => 'macOS brugere',
        'steps' => [
            'register' => [
                'title' => 'opret en bruger',
                'description' => 'følg instrukserne når spillet startes for at logge ind eller lave en ny konto',
            ],
            'download' => [
                'title' => 'hent spillet',
                'description' => 'klik på knappen ovenfor for at hente installeren, og kør den!',
            ],
            'beatmaps' => [
                'title' => 'få beatmaps',
                'description' => [
                    '_' => ':browse det gigantiske bibliotek af bruger-skabte beatmaps, og begynd at spille!',
                    'browse' => 'udforsk',
                ],
            ],
        ],
        'video-guide' => 'video-guide',
    ],

    'user' => [
        'title' => 'instrumentbræt',
        'news' => [
            'title' => 'Nyheder',
            'error' => 'Fejl ved indlæsning af nyheder, prøv at genindlæse siden?...',
        ],
        'header' => [
            'stats' => [
                'friends' => 'Venner Online',
                'games' => 'Spil',
                'online' => 'Online Brugere',
            ],
        ],
        'beatmaps' => [
            'new' => 'Nye Rangerede Beatmaps',
            'popular' => 'Populære Beatmaps',
            'by_user' => 'af :user',
        ],
        'buttons' => [
            'download' => 'Hent osu!',
            'support' => 'Støt osu!',
            'store' => 'osu!store',
        ],
    ],

    'support-osu' => [
        'title' => 'Wow!',
        'subtitle' => 'Du ser ud til at have det sjovt! :D',
        'body' => [
            'part-1' => 'Vidste du, at osu! kører helt uden reklamer og er stærkt afhængigt af, at spillerne støtter spillets udvikling og omkostninger?',
            'part-2' => 'Vidste du også, at du ved at støtte osu! får en stor håndfuld ekstra funktioner, såsom <strong>in-game downloading</strong> som kan udnyttes i multiplayer- og spectator-tilstand?',
        ],
        'find-out-more' => 'Klik her for at læse mere!',
        'download-starting' => "Oh, og bare rolig - din download er allerede blevet startet for dig ;)",
    ],
];
