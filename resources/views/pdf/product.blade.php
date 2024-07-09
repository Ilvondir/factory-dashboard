<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product | {{ $product->name }}</title>
    <style>
        body, .container {
            width: 100%;
            padding: 0;
            margin: 0;
            font-family: "Helvetica", "Arial", sans-serif;
        }

        .header, .footer {
            color: white;
            background-color: rgb(33, 37, 41);
            padding: 15px 0;
            text-align: center;
        }

        .product-name {
            text-align: center;
            font-size: 50px;
            margin: 15px;
        }

        .product-price {
            text-align: center;
            font-size: 30px;
            margin: 15px;
        }

        .product-department {
            color: #0D6EFD;
            font-size: 20px;
            text-align: center;
        }

        @page {
            margin: 0;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }

        table {
            width: 80%;
            margin-left: 10%;
            border-collapse: collapse;
            border: 1px solid rgba(0, 0, 0, 0.35);
            border-radius: 100px;
        }

        table caption {
            font-weight: 700;
        }

        table tr {
            border: 1px solid rgba(0, 0, 0, 0.35);
            border-radius: 100px;
        }

        table tr td {
            padding: 5px 10px;
        }

    </style>
</head>
<body>
<div class="container">

    <div class="header">
        <h1>Factory dashboard</h1>
    </div>

    <h1 class="product-name">
        {{ $product->name }}
    </h1>
    <h2 class="product-price">
        {{ $product->price }} PLN
    </h2>
    <h3 class="product-department">
        {{ $product->department->name }}
    </h3>

    <table>
        <caption>Materials</caption>
        @forelse($product->materials as $m)
            <tr>
                <td>
                    {{ $m->name }}
                </td>
            </tr>
        @empty
            <tr>
                <td>Nothing to show</td>
            </tr>
        @endforelse
    </table>

    <div class="footer">
        Report created {{ date("H:i:s") }}, {{ date("d.m.Y") }}
        by {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
    </div>
</div>
</body>
</html>
