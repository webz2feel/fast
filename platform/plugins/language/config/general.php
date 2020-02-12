<?php

return [

    // List supported modules or plugins
    'supported'               => [
        'Fast\Page\Models\Page',
        'Fast\Menu\Models\Menu',
        'Fast\Menu\Models\MenuLocation',
    ],

    // Negotiate for the user locale using the Accept-Language header if it's not defined in the URL?
    // If false, system will take app.php locale attribute
    'useAcceptLanguageHeader' => env('LANGUAGE_USE_ACCEPT_LANGUAGE_HEADER', true),

    // If LaravelLocalizationRedirectFilter is active and hideDefaultLocaleInURL
    // is true, the url would not have the default application language
    //
    // IMPORTANT - When hideDefaultLocaleInURL is set to true, the unlocalized root is treated as the applications default locale "app.locale".
    // Because of this language negotiation using the Accept-Language header will NEVER occur when hideDefaultLocaleInURL is true.
    //
    'hideDefaultLocaleInURL'  => env('LANGUAGE_HIDE_DEFAULT_LOCALE_IN_URL', true),

];
