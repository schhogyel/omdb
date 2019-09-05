<?php

$api_key = "530b3025";
$base_url = "http://www.omdbapi.com";

function getMoviesBySearch($query)
{
    if (isset($query) && $query != '') {
        global $base_url, $api_key;

        $url = $base_url . "?apikey=" . $api_key . "&s=" . urlencode($query);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);

        $search_results = json_decode($data);
        return $search_results->Search;
    }
}

function displayMovies($movies)
{
    $html = '';
    if (isset($movies) && sizeof($movies) > 0) {
        foreach ($movies as $movie) {
            if (stristr($movie->Title, 'red')) {
                $class = "red";
            } elseif (stristr($movie->Title, 'green')) {
                $class = "green";
            } elseif (stristr($movie->Title, 'blue')) {
                $class = "blue";
            } elseif (stristr($movie->Title, 'yellow')) {
                $class = "yellow";
            } else {
                $class = "";
            }

            $html .= '<div class="md:w-1/4 mb-4 px-2 ' . $class . '">'
                . '<div class="movie-card">'
                . '<img class="rounded-lg" src="' . $movie->Poster . '" alt="' . $movie->Title . '">'
                . '</div>'
                . '<div class="text-' . $class . '-500">'
                . '<h2 class="title-heading pt-2">' . $movie->Title . '</h2>'
                . $movie->Year . '<br />'
                . '</div>'
                . '</div>';
        }
        return $html;
    }
}

$colorCategory = array("red", "green", "blue", "yellow");

$movies = [];
foreach ($colorCategory as $color) {
    $movies = array_merge($movies, getMoviesBySearch($color));
}

?>

<!doctype html>
<html class="no-js" lang="">

<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="manifest" href="site.webmanifest">
    <link rel="apple-touch-icon" href="icon.png">
    <!-- Place favicon.ico in the root directory -->
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/normalize.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/custom.css">

    <meta name="theme-color" content="#fafafa">
</head>

<body>
    <!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->
    <header class="bg-indigo-500">
        <nav class="container mx-auto flex items-center justify-between flex-wrap  p-6">
            <div class="flex items-center flex-shrink-0 text-white mr-6">
                <span class="font-semibold text-xl tracking-tight">oMDB: Open Movie Database</span>
            </div>
        </nav>
    </header>
    <div class="container mx-auto mt-8">
        <div class="flex flex-wrap -mb-4 justify-center">
            <?php
            echo displayMovies($movies);
            ?>
        </div>
    </div>

    <!-- Add your site or application content here -->
    <script src="js/vendor/modernizr-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="js/vendor/jquery-3.4.1.min.js"><\/script>')
    </script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>

    <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
    <script>
        window.ga = function() {
            ga.q.push(arguments)
        };
        ga.q = [];
        ga.l = +new Date;
        ga('create', 'UA-XXXXX-Y', 'auto');
        ga('set', 'transport', 'beacon');
        ga('send', 'pageview')
    </script>
    <script src="https://www.google-analytics.com/analytics.js" async></script>
</body>

</html>