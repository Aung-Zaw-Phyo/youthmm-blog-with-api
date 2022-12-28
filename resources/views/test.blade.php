<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <div class="container py-5">
        <h1 class="text-center">Time Testing Page</h1>
        <div class="row mt-3">
            @foreach($users as $user)
                <div class="col-lg-3 p-3">
                    <p>{{ $user->name }}</p>
                    <p>
                        {{ $user->created_at }} <br>
                        {{ now() }} <br>

                        @if ($user->created_at->addDays(6) <= now())
                            {{ 'true' }}
                        @else
                        {{ 'false' }}
                        @endif
                        <br>
                        id is {{ $user->id }} and ban is {{ $user->ban_date_limit }} <br> <br>
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
