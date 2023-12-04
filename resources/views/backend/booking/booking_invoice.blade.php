<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>Invoice</title>

<style type="text/css"> 
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
    .font{
      font-size: 15px;
    }
    .authority {
        /*text-align: center;*/
        float: right
    }
    .authority h5 {
        margin-top: -10px;
        color: green;
        /*text-align: center;*/
        margin-left: 35px;
    }
    .thanks p {
        color: green;;
        font-size: 16px;
        font-weight: normal;
        font-family: serif;
        margin-top: 20px;
    }
</style>

</head>
<body>

  <table width="100%" style="background: #F7F7F7; padding:0 20px 0 20px;">
    <tr>
        <td valign="top">
          <!-- {{-- <img src="" alt="" width="150"/> --}} -->
          <h2 style="color: green; font-size: 26px;"><strong>EasyShop</strong></h2>
        </td>
        <td align="right">
            <pre class="font" >
               EasyShop Head Office
               Email:admin@admin.com <br>
               Mob: 1245454545 <br>
               Address - Italy <br>
            </pre>
        </td>
    </tr>

  </table>


  <table width="100%" style="background:white; padding:0 5 0 5px;" class="font">
    <thead class="table-light">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Country</th>
            <th>State</th>
            <th>Zip Code</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $booking['user']['name'] }}</td>
            <td>{{ $booking['user']['email'] }}</td>
            <td>{{ $booking->phone }}</td>
            <td>{{ $booking->address }}</td>
            <td>{{ $booking->country }}</td>
            <td>{{ $booking->state }}</td>
            <td>{{ $booking->zip_code }}</td>
        </tr>
    <tbody>
  </table>

  <table width="100%" style="background: #F7F7F7; padding:0 5 0 5px;" class="font">
     <thead class="table-light">
        <tr>
            <th>Room Type</th>
            <th>Total Room</th>
            <th>Price</th>
            <th>Check-In/Out Date</th>
            <th>Total Days</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $booking['room']['roomType']['name'] }}</td>
            <td>{{ $booking->number_of_rooms }}</td>
            <td>€ {{ $booking->actual_price }}</td>
            <td><span class="badge bg-primary">{{ $booking->check_in }}</span> / </br> <span class="badge bg-warning text-dark"> {{ $booking->check_out  }} </span></td>
            <td>{{ $booking->total_night }}</td>
            <td>€ {{ $booking->total_price }}</td>
        </tr>
    <tbody>
              
  </table>
  <br/>
 


   
    <style> 
        .test_table td { text-align: right; }
    </style>
    <table class="table test_table" style="float: right" border="none">
                           
        <tr>
            <th>Subtotal</th>
            <td>{{ $booking->subtotal }}</td>
        </tr>
        <tr>
            <th>Discount</th>
            <td>{{ $booking->discount  }}</td>
        </tr>
        <tr>
            <th>Total</th>
            <td>{{ $booking->total_price  }}</td>
        </tr>
        

    </table>   


  <div class="thanks mt-3">
    <p>Thanks For Your Booking..!!</p>
  </div>
  <div class="authority float-right mt-5">
      <p>-----------------------------------</p>
      <h5>Authority Signature:</h5>
    </div>
</body>
</html>