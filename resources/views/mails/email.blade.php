<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>@yield('title')</title>
    <style type="text/css">


        body {
        }

        .content {
        }

        .header {
        }

        .subhead {
        }

        .h1 {
        }

        .h1, .h2 {
        }

        .bodycopy {
        }

        .innerpadding {
        }

        .borderbottom {
            border-bottom: 1px solid #f2eeed;
        }

        .h2 {
            padding: 0 0 15px 0;
            font-size: 24px;
            line-height: 28px;
            font-weight: bold;
        }

        .bodycopy {
        }

        .button {
            border-radius: 2px;
        }

        .button a {
            padding: 8px 12px;
            border: 1px solid #ED2939;
            border-radius: 2px;
            font-family: Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
        }


    </style>
</head>
<body yahoo bgcolor="#f6f8f1" style="margin: 0; padding: 0; min-width: 100%!important;">
<table width="100%" bgcolor="#f6f8f1" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table class="content" align="center" cellpadding="0" cellspacing="0" border="0" style="">
                <tr>
                    <td class="header" bgcolor="#EE1D25" style="padding: 40px 30px 20px 30px;">


                        <table width="1024" align="left" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td height="70" style="padding: 0 20px 20px 0;">


                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td class="subhead"
                                                style="padding: 0 0 0 3px;font-size: 15px; color: #fbe0ff; font-family: sans-serif; letter-spacing: 10px;">
                                                FJEP <br>Gymnastique
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="h1"
                                                style="padding: 5px 0 0 0;font-size: 33px; line-height: 38px; font-weight: bold; color: #fbe0ff;font-family: sans-serif; ">

                                                @yield('title')
                                            </td>
                                        </tr>
                                    </table>


                                </td>
                            </tr>
                        </table>

                    </td>

                </tr>


                <tr>
                    <td class="innerpadding borderbottom " style="padding: 30px 30px 30px 30px;">


                        <table class="col380" align="left" border="0" cellpadding="0" cellspacing="0"
                               style="width: 100%; ">
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td class="bodycopy"
                                                style="color: #0a0a0a; font-family: sans-serif;font-size: 16px; line-height: 22px;">
                                                @yield('content')
                                            </td>
                                        </tr>
                                    <!--<tr>
              <td style="padding: 20px 0 0 0;">
                <table class="buttonwrapper" bgcolor="#7D3C8F" border="0" cellspacing="0" cellpadding="0" style="text-align: center; font-size: 18px; font-family: sans-serif; font-weight: bold; padding: 0 30px 0 30px;">
                  <tr>
                    <td class="button" height="45">
                      <a href="@yield('url')" style="color: #ffffff; text-decoration: none;">@yield('url')</a>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>-->
                                    </table>
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
