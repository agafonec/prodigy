
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>New Availability</title>
</head>
<body style="background:#edf7ff;">
<style>
@font-face {
  font-family: 'Helvetica';
  src: url('Helvetica.eot') format('embedded-opentype');
  font-weight: normal;
  font-style: normal;
}



tbody tr:nth-child(odd) {
   background-color: #e3e3e3;
}

tbody tr:nth-child(even) {
   background-color: #d9d9d9;
}




@media only screen and (min-width:0px) and (max-width: 480px) {
	.container-email { width:100%;}
	h1 { line-height:30px!important;}
	.message p {
    font-size: 12px !important;
    line-height: 25px !important;
}
	}



@media only screen and (min-width:0px) and (max-width: 600px) {
	.container-email { width:100%;}

	}

</style>
<div style="max-width:600px; width:100%; margin:0 auto; box-sizing:border-box; margin-bottom:20px; ">
  <div  style="width:100%; float:left; background:#fff;box-sizing:border-box; border:1px solid #ddd;">
    <!--Paragraph Link Start -->
    <div style="width:100%; float:left;">
      <h1 style="font-family:Arial, Helvetica, sans-serif; font-size:18px; font-weight:bold; text-align:center; line-height:30px; color:#37a0c9;">New Availability For This Courses </h1>
      <div style="width:100%; float:left; border-top:1px solid #ddd; padding:0 0;">
    <!--  <p style="font-family:'Helvetica', sans-serif; font-size:14px; text-align:left;line-height:20px;  margin:0px;  color:#505050; padding-left:15px;padding-bottom:15px; text-align:left">Please approve these subject that have been submit by this users {{$send_data['username']}} , please check the subject below :</p> -->
      </div>
    </div><!---->



    <div style="width:100%; float:left;">
<style>
table {
    border-collapse: collapse;
}

table, td {
    border: 1px solid #ebebeb;
	padding:10px;
	font-family: 'Helvetica',sans-serif; font-size:14px;
}
</style>

      <table style="width:91%; margin:0 auto;">
        <tr><th>Detials</th></tr>
        <tr style="background-color: #e3e3e3;">

          <td style="width:30%;padding:10px"><strong>  Name </strong></td>
          <td style="width:70%;padding:10px">{{$send_data['username']}}</td>
        </tr>
        <tr style=" background-color: #d9d9d9;">
          <td style="width:30%;padding:10px"><strong> Email </strong></td>
          <td style="width:30%;padding:10px">{{$send_data['email_address']}}</td>
        </tr>
        <tr style=" background-color: #d9d9d9;">
          <td style="width:30%;padding:10px"><strong> Course </strong></td>
          <td style="width:30%;padding:10px">{{$send_data['courses']}}</td>
        </tr>
        <tr style=" background-color: #d9d9d9;">
          <td style="width:30%;padding:10px"><strong> Availability </strong></td>
          <td style="width:30%;padding:10px">{{$send_data['availability']}}</td>
        </tr>
      </table>

    </div>

    <!-- Table End -->

    <!-- Footer Start -->
    <div style="width:100%; float:left; padding:10px 0; text-align:center; box-sizing:border-box;">

    </div>

<!--     <div style="width:97%; float:left; background:#c7edfc; color:#353535; padding:10px; text-align:left; box-sizing:border-box;">
          <p style="font-family:'Helvetica', sans-serif; font-size:14px;  margin:0px 0; text-align:center">Kind regards,</p>
          <p style="font-family:'Helvetica', sans-serif; font-size:15px;  margin:5px 0px;  text-align:center; font-weight:bold; color:#000;"> Nick Ogle,</p>
          <p style="font-family:'Helvetica', sans-serif; font-size:14px;   margin:0px; text-align:center"> MENA Council co-founder and CEO</p>
        </div>-->
    <!-- Footer End -->

  </div>
</div>
<div style="clear:both"></div>
</body>
</html>

