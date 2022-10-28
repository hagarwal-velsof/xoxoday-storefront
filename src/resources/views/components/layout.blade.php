<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alcobrew </title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/daisyui@2.20.0/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script> -->
    <script type="text/javascript" src="{{asset('storefront/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('storefront/js/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{asset('storefront/js/validation.js')}}"></script>
    <script type="text/javascript" src="https://getbootstrap.com/docs/5.0/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{asset('storefront/css/style.css')}}" />
    <link href="{{asset('storefront/css/bootstrap.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('storefront/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('storefront/css/spinwheel.css')}}">
    <link rel="stylesheet" href="{{asset('storefront/css/css2')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
      var blkd_context = {
        "current_step": "execute", 
        "next_step": "success"
      };
    </script>
  </head>
  <body>

  {{ $slot }}

  </body>
</html>
