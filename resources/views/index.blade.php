<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Free API List for some services.">
    <meta name="author" content="Muhammed Efe Cetin">
    <link rel="icon" href="{{ URL::to('favicon.png') }}">

    <title>API Collection</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

</head>

<body>
    <main role="main">
        <section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading">API Collection</h1>
                <p class="lead text-muted">Free API List for some services.</p>
                <p>
                    <a href="https://github.com/efectn/api-collection" class="btn btn-primary my-2">Visit Repository</a>
                    <a href="https://github.com/efectn/api-collection/pulls" class="btn btn-secondary my-2">Make
                        Contribution</a>
                </p>
            </div>
        </section>

        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card mb-4 box-shadow" style="width: 21.5em;margin:0 auto;">
                            <img class="card-img-top"
                                src="{{ URL::to('images/diyanet.jpg') }}"
                                alt="Diyanet">
                            <div class="card-body">
                                <b class="card-text">Usage:</b>
                                <p>Country List: <a href="{{ route('countries') }}">/countries</a><br>
                                Location List: <a href="{{ route('locations', ['country_id' => 1]) }}">/locations/{country_id}</a><br>
                                Pray Time List: <a href="{{ route('times', ['location_id' => 15153]) }}">/times/{location_id}</a></p>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="https://namazvakitleri.diyanet.gov.tr/" class="btn btn-sm btn-outline-secondary" role="button" aria-pressed="true">Source</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4 box-shadow" style="width: 21.5em;margin:0 auto;">
                            <img class="card-img-top"
                                 src="{{ URL::to('images/horoscopes.jpg') }}"
                                 alt="Diyanet">
                            <div class="card-body">
                                <b class="card-text">Usage:</b>
                                <p>Horoscope List: <a href="{{ route('horoscopes') }}">/horoscope/signs</a><br>
                                    Horoscope Interpretation: <a href="{{ route('horoscopes.interpretation', ['horoscope_name' => 'koc']) }}">/horoscope/interpretation/{horoscope_name}</a></p>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="https://www.hurriyet.com.tr/mahmure/astroloji/" class="btn btn-sm btn-outline-secondary" role="button" aria-pressed="true">Source</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4 box-shadow" style="width: 21.5em;margin:0 auto;">
                            <img class="card-img-top"
                                 src="{{ URL::to('images/earthquake.jpg') }}"
                                 alt="Earthquake">
                            <div class="card-body">
                                <b class="card-text">Usage:</b>
                                <p>Last Earhquakes: <a href="{{ route('earthquake.list', ['limit' => 1000]) }}">/earthquake/list/{limit} (max 1000)</a><br></p>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="http://sc3.koeri.boun.edu.tr/eqevents/events.html" class="btn btn-sm btn-outline-secondary" role="button" aria-pressed="true">Source</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-muted">
        <div class="container">
            <p>Made by <a href="https://github.com/efectn/">Muhammed Efe Çetin</a></p>
        </div>
    </footer>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
</body>

</html>
