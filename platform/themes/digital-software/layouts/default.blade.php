<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <link rel="canonical" href="{{ url('/') }}">
        <meta http-equiv="content-language" content="en">

        <title>{{ SeoHelper::getTitle() }}</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&amp;display=swap">
        {!! Theme::header() !!}
    </head>
    <body>
        <div class="wrapper">
            {!! Theme::partial('header') !!}
            <main class="main">
                {!! Theme::content() !!}
            </main>
            {!! Theme::partial('footer') !!}
        </div>
        {!! Theme::footer() !!}
    </body>
</html>
