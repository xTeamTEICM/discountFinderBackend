<!DOCTYPE html>
<html lang="en">
<head>
    @if(app('request')->input('id') != null)
        <title>{{ \App\category::find(\App\Discount::find(app('request')->input('id'))['category'])['title'] }}</title>
    @else
        <title>Προσφορές</title>
    @endif
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        /* Remove the navbar's default margin-bottom and rounded borders */
        .navbar {
            margin-bottom: 0;
            border-radius: 0;
        }

        /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
        .row.content {
            height: 450px
        }

        /* Set gray background color and 100% height */
        .sidenav {
            padding-top: 20px;
            background-color: #f1f1f1;
            height: 100%;
        }

        /* Set black background color, white text and some padding */
        footer {
            background-color: #555;
            color: white;
            padding: 15px;
        }

        /* On small screens, set height to 'auto' for sidenav and grid */
        @media screen and (max-width: 767px) {
            .sidenav {
                height: auto;
                padding: 15px;
            }

            .row.content {
                height: auto;
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Προσφορές</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li><a href="{{ url('/') }}">Αρχική</a></li>
                <li><a href="{{ url('/shop') }}">Καταστήματα</a></li>
                <li class="active"><a href="{{ url('/discount') }}">Προσφορές</a></li>
                <li><a href="{{ url('/about') }}">Σχετικά με</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid text-center">
    <div class="row content">
        <img class="text-center">
        @if(app('request')->input('id') != null)
            <h1>{{ \App\category::find(\App\Discount::find(app('request')->input('id'))['category'])['title'] }}</h1>
            <p>
            <hr/>
            <img height="256px" src="{{ \App\Discount::find(app('request')->input('id'))['image'] }}"/> <br/>
            <h3>Μαγαζί</h3> <a
                    href="{{ url('/shop') . '?id=' . \App\Discount::find(app('request')->input('id'))['shopId']  }}">{{ \App\Shop::find(\App\Discount::find(app('request')->input('id'))['shopId'])['brandName'] }}</a>
            <br/>
            <h3>Πόλη</h3> {{ \App\Shop::find(\App\Discount::find(app('request')->input('id'))['shopId'])['city'] }}
            <br/>
            <h3>Περιγραφή</h3> {{ \App\Discount::find(app('request')->input('id'))['description'] }} <br/>
            Από {{ \App\Discount::find(app('request')->input('id'))['originalPrice'] }}€
            μόνο {{ \App\Discount::find(app('request')->input('id'))['currentPrice'] }}€ <br/>
            <br/>
            </p>
        @else
            <h1>Προσφορές</h1>
            <p>
            @foreach(\App\Discount::all() as $discount)
                <hr/>
                <a href="{{ url('/discount') . '?id=' . $discount['id'] }}"><img height="256px"
                                                                                 src="{{ $discount['image'] }}"/></a>
                <br/>
                <h3>Κατηγορία</h3> {{ \App\category::find($discount['category'])['title'] }} <br/>
                <h3>Μαγαζί</h3> <a
                        href="{{ url('/shop') . '?id=' . $discount['shopId']  }}">{{ \App\Shop::find($discount['shopId'])['brandName'] }}</a>
                <br/>
                <h3>Πόλη</h3> {{ \App\Shop::find($discount['shopId'])['city'] }} <br/>
                <h3>Περιγραφή</h3> {{ $discount['description'] }} <br/>
                Από {{ $discount['originalPrice'] }}€ μόνο {{ $discount['currentPrice'] }}€ <br/>
            @endforeach
            <br/>
            </p>
        @endif
    </div>
</div>
</div>


</body>
</html>
