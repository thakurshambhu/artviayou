<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Artviayou</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                    <tr>
                        <td align="center" bgcolor="#f2f2f2" style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                            <a href="{{url('/')}}"><img src="{{asset('assets/images/artvi-croppd.png')}}" alt="" style="height: 50px; width: 50px;"></a>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                               	<tr>
                                    <td style="padding: 10px 0 10px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        Hi,
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0 10px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        A commission request from  <a href="{{url('profile')}}/{{$data['alias']}}">{{$data['user_name']}}</a> has been Denied by <a href="{{url('profile_details')}}/{{$data['artist_id']}}">{{$data['artist_name']}}</a>.
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0 10px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                       	Artist Email: {{$data['artist_email']}}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px 0 10px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        @if($data['role'] == "buyer")
                                       	Buyer Email: {{$data['user_email']}}
                                        @else
                                        Gallery Email: {{$data['user_email']}}
                                        @endif
                                    </td>
                                </tr>
                                   
                               
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#1DA1F2" style="padding: 30px 30px 30px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
                                        Thanks,<br/>Artviayou.
                                       
                                    </td>
                        
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>