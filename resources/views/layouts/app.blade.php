<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopify-App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    @yield('css')
</head>
<body style="padding: 20px 0px;">
    <div class="container-fluid">
        @yield('content')
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.8/dist/sweetalert2.all.min.js"></script>
    <script>
    $(document).ready(function(){
        @if(Session::get('success'))
            Swal.fire(
              'Success',
              '{{ Session::get("success") }}',
              'success'
            );
        @endif

        @if(Session::get('error'))
            Swal.fire(
              'Error',
              '{{ Session::get("error") }}',
              'error'
            );
        @endif
    });
    </script>
@yield('js')
</body>
</html>