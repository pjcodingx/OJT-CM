
<!----THE SKELETON----->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'Your Default Title')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" sizes="32x32" href="{{ asset('favicon/cmlogo.png') }}" type="image/png">

    {{-- !TEMPORARY REMOVAL OF TAILWIND --}}
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}

    @yield('styles')
</head>
<body>


    @yield('content')



    @yield('scripts')
</body>
</html>
