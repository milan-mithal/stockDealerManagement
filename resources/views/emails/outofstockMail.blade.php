<!DOCTYPE html>
<html>
<head>
  <style>
    /* Reset some default styling */
    body, p, h1, h2, h3, h4, h5, h6 {
      margin: 0;
      padding: 0;
    }
  </style>
</head>
<body style="font-family: Arial, sans-serif;">

  <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px;">
    <tr>
      <td style="background-color: #f5f5f5; padding: 20px; text-align: center;">
        <h1 style="color: #333;">Out Of Stock Details</h1>
      </td>
    </tr>
    <tr>
      <td style="padding: 20px;">
        <p>Please find below out of stock products:</p>
        
        <table cellspacing="0" cellpadding="10" border="1" width="100%">
          <tr>
            <th>Product Code</th>
            <th>Quantity left</th>
          </tr>
          @foreach ($mailData['allOutOfStockProducts'] as $allOutOfStockProducts)
          <tr>
            <td>{{ $allOutOfStockProducts->product_code }}</td>
            <td>{{ $allOutOfStockProducts->stock_qty }}</td>
          </tr>
          @endforeach
        </table>
      </td>
    </tr>
    <tr>
      <td style="background-color: #f5f5f5; padding: 20px; text-align: center;">
        <p>Thanks</p>
        <p>Shams Naturals Team</p>
      </td>
    </tr>
  </table>

</body>
</html>
