<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Yammluck Receipt</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />
</head>
<style>
    body {
        background-color: #f1f1f1;
        font-family: "Poppins", sans-serif;
    }

    .container {
        max-width: 600px;
        margin: 5% auto;
    }

    .logo {
        max-width: 70px;
        margin: 0 auto;
    }

    .logo img {
        width: 100%;
        display: block;
    }

    .card {
        background-color: white;
        padding: 10px;
        border-radius: 3px;
    }

    .order-information .heading {
        border-bottom: 1px solid #d1d1d1;
        color: #b2b2b2;
        font-weight: 500;
        line-height: 2.2em;
        font-size: 15px;
    }

    .order-information .row {
        display: flex;
        justify-content: space-between;
        margin-top: 2%;
        padding: 0px 5px 0 5px;
    }

    .order-information .col {
        line-height: 2em;
        width: 290px;
        max-width: 100%;
        overflow: hidden;
    }

    .what-you-ordered {
        margin-top: 3%;
    }

    .what-you-ordered .heading {
        border-bottom: 1px solid #d1d1d1;
        color: #b2b2b2;
        font-weight: 500;
        line-height: 2.2em;
        font-size: 15px;
    }

    table {
        width: 100%;
        text-align: left;
        margin: 0px auto 15px;
        padding: 5px 0px;
        border-bottom: 1px solid #d1d1d1;
    }

    table th {
        background-color: #f1f1f1;
        padding-left: 10px;
        font-size: 14px;
        line-height: 40px;
    }

    table td {
        font-size: 14px;
        padding: 10px;
    }

</style>

<body>
    <div class="container">
        <div class="logo">
            <a href="https://yammluck.com">
                <img src="https://i.ibb.co/ZhczmzW/YAM-LUCK-2-png.png" alt="Yammluck Logo" />
            </a>
        </div>
        <div style="
          font-weight: bold;
          font-size: 50px;
          color: #313131;
          text-align: center;
          line-height: 120px;
        ">
            Thank You.
        </div>
        <div class="card">
            <div style="text-align: center; line-height: 2em">
                <div style="font-weight: bold; font-size: 18px">Hi
                    {{ DB::table('users')->where('id', $getInvoice->user_id)->pluck('full_name')->first() }}!
                </div>
                <div style="font-size: 13px">
                    Thanks for your purchase from Yammluck, Ltd.
                </div>
                <strong style="
              font-size: 35px;
              line-height: 40px;
              text-transform: uppercase;
              margin: 3% auto;
              display: block;
              color: #222;
            ">
                    invoice id:
                    <br />
                    {{ $getInvoice->invoice_id }}
                </strong>
            </div>
            <div class="order-information">
                <div class="heading">YOUR ORDER INFORMATION:</div>
                <div class="row">
                    <div class="col">
                        <strong>Order ID</strong>
                        <div>{{ $getInvoice->id }}</div>
                    </div>
                    <div class="col">
                        <strong>Bill To:</strong>
                        <div>{{ DB::table('users')->where('id', $getInvoice->user_id)->pluck('email')->first() }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <strong>Order Date:</strong>
                        <div>{{ $getInvoice->order_date }}</div>
                    </div>
                    <div class="col">
                        <strong>Payment Method:</strong>
                        <div>{{ $getInvoice->payment }}</div>
                    </div>
                </div>
            </div>
            <div class="what-you-ordered">
                <div class="heading">HERE'S WHAT YOU ORDERED:</div>
                <table>
                    <tr>
                        <th>Description</th>
                        <th>Publisher</th>
                        <th>Price</th>
                    </tr>
                    <tr>
                        <td>{{ $getInvoice->description }}</td>
                        <td>{{ $getInvoice->publisher }}</td>
                        <td>USD ${{ $getInvoice->price }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>
                            <span style="font-weight: bold; color: #b2b2b2">
                                TOTAL [ USD ]:
                            </span>
                            <span style="font-weight: bold"> ${{ $getInvoice->price }} </span>
                        </td>
                    </tr>
                </table>
                <div class="total"></div>
            </div>
        </div>
        <strong style="
          font-size: 11px;
          text-align: center;
          display: block;
          margin: 11px auto;
        ">
            Need Help?
            <a href="https://yammluck.com/help" style="color: #4545ef; text-decoration: none">Yammluck.com/help</a>
        </strong>
        <p style="text-align: center; font-size: 12px; color: #858585">
            &copy; 2022 Yammluck, Ltd. All rights reserved
        </p>
        <div style="display: flex; justify-content: center; gap: 10px">
            <a href="https://yammluck.com/terms" style="font-size: 13px; color: #4545ef">
                Terms of Service
            </a>
            <a href="https://yammluck.com/privacy" style="font-size: 13px; color: #4545ef">
                Privacy Policy
            </a>
        </div>
    </div>
</body>

</html>
