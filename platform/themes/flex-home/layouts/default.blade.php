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

    {!! Theme::header() !!}

    <!-- Fonts-->
    <link href="https://fonts.googleapis.com/css?family={{ theme_option('primary_font', 'Nunito Sans') }}:300,600,700,800" rel="stylesheet" type="text/css">
    <!-- CSS Library-->

    <style>
        body {font-family: '{{ theme_option('primary_font', 'Nunito Sans') }}', sans-serif !important;}
    </style>
</head>
<body>
    {!! Theme::partial('header') !!}

    <div id="app">
        {!! Theme::content() !!}
    </div>

    {!! Theme::partial('footer') !!}

    {!! Theme::footer() !!}

    <!--END FOOTER-->

    <div class="action_footer">
        <a href="#" class="cd-top"><i class="fas fa-arrow-up"></i></a>
        <a href="tel:{{ theme_option('hotline') }}" style="color: white;font-size: 18px;"><i class="fas fa-phone"></i> <span>  &nbsp;{{ theme_option('hotline') }}</span></a>
    </div>
    <div id="loading">
        <div class="lds-hourglass">
        </div>
    </div>
</body>
</html>
