<?php

/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'meta' => [
        /**
         * The default configurations to be used by the meta generator.
         */
        'defaults' => [
            'title' => env('APP_NAME'), // set false to total remove
            'titleBefore' => false, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description' => 'Introducing the Voting App: the easiest and most convenient way to cast your ballot. With our app, you can vote from the comfort of your own phone anytime, anywhere. Say goodbye to long lines at polling stations and hello to the future of democracy. Our app is secure, ensuring that your vote is safe and counted. Make your voice heard and exercise your civic duty with the Voting App. Download now and make a difference.', // set false to total recoove
            'separator' => ' - ',
            'keywords' => [
                'Election',
                'Democracy',
                'Civic duty',
                'Political participation',
                'Ballot',
                'Voter turnout',
                'Voting rights',
                'Voting booth',
                'Polling station',
                'Voting process',
                'Voting system',
                'Voting machine',
                'Voting',
                'Vote',
                'Election',
                'Democracy',
                'Website',
                'Cast your ballot with our app',
                'Vote from your phone',
                'Election season just got easier',
                'One click voting',
                'Make your voice heard',
                'Exercise your democratic right',
                'Your vote, your choice',
                'Easy, secure, and convenient voting',
                'Get the app, cast your vote',
                'Every vote counts',
                'Online voting made simple',
                'Mobile voting for modern democracy',
                'Paperless polling: Vote anytime, anywhere',
                'E-voting for a greener future',
                'Streamline your voting process with our app',
                'Secure digital voting for all',
                'Election day just got easier with our app',
                'Voting made accessible with our app',
                'Your vote, your power',
                'Make a difference with your vote',
                'Online voting',
                'Mobile voting',
                'E-voting',
                'Digital voting',
                'Convenient voting',
                'Secure voting',
                'Easy voting',
                'Paperless polling',
                'Vote from your phone',
                'Voting app',
            ],
            'canonical' => 'full', // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots' => false, // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /**
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google' => null,
            'bing' => null,
            'alexa' => null,
            'pinterest' => null,
            'yandex' => null,
            'norton' => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /**
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title' => '', // set false to total remove
            'description' => '', // set false to total remove
            'url' => null, // Set null for using Url::current(), set false to total remove
            'type' => false,
            'site_name' => env('APP_NAME'),
            'images' => [
                // asset('img/logo.svg'),
            ],
        ],
    ],
    'twitter' => [
        /**
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            //'card'        => 'summary',
            //'site'        => '@LuizVinicius73',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title' => env('APP_NAME'), // set false to total remove
            'description' => 'Introducing the Voting App: the easiest and most convenient way to cast your ballot. With our app, you can vote from the comfort of your own phone anytime, anywhere. Say goodbye to long lines at polling stations and hello to the future of democracy. Our app is secure, ensuring that your vote is safe and counted. Make your voice heard and exercise your civic duty with the Voting App. Download now and make a difference.', // set false to total recoove
            'url' => 'full', // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'type' => 'WebPage',
            'images' => [
                // asset('img/logo.svg'),
            ],
        ],
    ],
];
