<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

    <title>Stats</title>
</head>
<body>

    <div class="statistics-box">

        <div class="graph">
            {!! $chartjs1->render() !!}
        </div>
    
        <div class="graph">
            {!! $chartjs2->render() !!}
        </div>
    
    </div>

   
</body>
</html>