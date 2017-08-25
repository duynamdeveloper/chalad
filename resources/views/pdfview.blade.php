<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Chenk Out | Invoice</title>
</head>
<style>
 body{ font-family:Arial, Helvetica, sans-serif; color:#121212; line-height:22px;}
</style>
<body>

  <div style="width:900px; margin:15px auto; padding-bottom:40px;">
    <div style="width:450px; float:left;">
   <h1>Stock Manager</h1>
  
  <div style="margin-top:70px;">
    <div style="font-size:16px; color:#000000; font-weight:bold;">{{ Session::get('name') }}</div>
    <div style="font-size:16px;">{{date("l jS \of F Y h:i:s A")}}</div>
    
  </div>
  </div>
  <div style="width:450px; float:right;">
    <h1 style="text-align:right;">INVOICE</h1>
    <h4 style="text-align:right; color:#666666; line-height:0px;"># INV-{{ sprintf("%04d", $id)}}</h4>
    <br />
    <div style="margin-top:70px; text-align:right;">
      <div style="font-size:16px; color:#000000; font-weight:bold;">Bill To</div>
      <div style="font-size:16px;">{{$customerData->name}}</div>
      <div style="font-size:16px;">{{$customerData->address}}</div>
      <div style="font-size:16px;">Conatact : {{$customerData->phone}}</div>
    </div>
    <br />

  </div>
  
  <div style="clear:both"></div>
    <div style="background-color:#323a45; padding:10px 20px;height:20px">
      <div style="width:200px; color:#FFFFFF; float:left; font-weight:bold;">Item Code</div>
      <div style="width:460px; color:#FFFFFF; float:left; font-weight:bold;">Item Description</div>
      <div style="width:200px; text-align:center; color:#FFFFFF; float:left; font-weight:bold;">Quantity</div>
      <div style="clear:both"></div>
    </div>
  <?php
    $sum = 0;
  ?>
  @foreach ($invoiceData as $item)
    <div style="padding:0px 20px; margin-top:15px;">
      <div style="width:200px; font-size:14px; float:left;">{{$item->stk_code}}</div>
      <div style="width:460px; float:left; font-size:14px; text-align:justify;">{{$item->description}}</div>
      <div style="width:200px; text-align:center; font-size:14px; float:left;">{{$item->quantity}}</div>

    </div>
   <br/>
<div style="clear:both"></div>
  <?php
    $sum = $item->quantity+$sum;
  ?>
  @endforeach  
    <div style="clear:both"></div>
    <br/>
    <div style="padding:0px 20px; ">
    <hr />
      <div style="width:460px; float:left; font-size:14px; text-align:justify;">&nbsp;</div>
      <div style="width:200px; text-align:right; font-size:14px; float:left; font-weight:bold;">Total</div>
      <div style="width:200px; text-align:center; font-size:14px; float:left;">{{$sum}}</div>

    </div><br /><br />
       
  </div>
</body>
</html>