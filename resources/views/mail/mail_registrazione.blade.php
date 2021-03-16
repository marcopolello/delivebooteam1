<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
		<style>
			* {
				font-family: sans-serif !important;
			}
		</style>

    <style type="text/css">

        html,
        body {
	        margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
        }

        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What is does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin:0 !important;
        }

        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            Margin: 0 auto !important;
        }
				.shadow-table{
					box-shadow: rgb(0 0 0 / 24%) 0px 3px 8px;
				}
        table table table {
            table-layout: auto;
        }

        img {
            -ms-interpolation-mode:bicubic;
        }

        .mobile-link--footer a,
        a[x-apple-data-detectors] {
            color:inherit !important;
            text-decoration: underline !important;
        }

    </style>

    <style>
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }
        .button-td:hover,
        .button-a:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }

        /* Media Queries */
        @media screen and (max-width: 600px) {

            .email-container {
                width: 100% !important;
                margin: auto !important;
                box-shadow: rgb(0 0 0 / 24%) 0px 3px 8px;
            }

            .fluid,
            .fluid-centered {
                max-width: 100% !important;
                height: auto !important;
                Margin-left: auto !important;
                Margin-right: auto !important;
            }
            .fluid-centered {
                Margin-left: auto !important;
                Margin-right: auto !important;
            }

            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }
            .stack-column-center {
                text-align: center !important;
            }


            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                Margin-left: auto !important;
                Margin-right: auto !important;
                float: none !important;
            }
            table.center-on-narrow {
                display: inline-block !important;
            }

        }

    </style>

</head>
<body bgcolor="#E0F3F9" width="100%" style="Margin: 0;">
    <center style="width: 100%; background: #E0F3F9;">


        <!-- Email Body : BEGIN -->
        <table cellspacing="0" cellpadding="0" border="0" align="center" bgcolor="#ffffff" width="600" style="margin: auto;" class="email-container">

            <!-- Hero Image, Flush : BEGIN -->
        <tr>
				<td>
					<img src="https://www.datocms-assets.com/15991/1581672962-roothumbnail.png?auto=format" width="600" height="" alt="alt_text" border="0" align="center" style="width: 100%; max-width: 600px;">
				</td>
        </tr>
            <!-- Hero Image, Flush : END -->
						<!-- 1 Column Text : BEGIN -->
            <tr>
                <td style="padding: 40px; text-align: center; font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555;">
									Gentile {{ $user -> name }}, <br>
									il tuo account Deliveboo è stato creato. <br>
									Ti ricordiamo l' email che hai scelto in fase di registrazione: <br>
									<h2>{{$user -> email}}</h2>
									Ora che sei registrato, potrai amministrare la tua attività nella tua home personale.
									Un piccolo riepilogo degli altri dati con cui ti sei registrato: <br>
									Indirizzo: {{$user -> address}} <br>
									Recapito telefonico: {{$user -> phone}}  <br>
									la tua Partita Iva: {{$user -> piva}} <br>
									costo di spedizione impostato: {{$user -> deh3very_cost / 10}} €
									<br> <br>
									Cordiali saluti, <br>
									Team 1
                    <br><br>
                    <!-- Button : Begin -->
                    <table cellspacing="0" cellpadding="0" border="0" align="center" style="Margin: auto">
                        <tr>
                            <td style="border-radius: 3px; background: #222222; text-align: center;" class="button-td">
                                <a href="http://localhost:8000/" style="background: #222222; border: 15px solid #222222; font-family: sans-serif; font-size: 13px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
                                    &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#ffffff">Home del sito</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                </a>
                            </td>
                        </tr>
                    </table>
                    <!-- Button : END -->
                </td>
            </tr>

            <!-- Thumbnail Left, Text Right : BEGIN -->
            <tr>
                <td dir="ltr" align="center" valign="top" width="100%" style="padding: 10px;">
                    <table class="shadow-table" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <!-- Column : BEGIN -->
                            <td width="33.33%" class="stack-column-center">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td dir="ltr" valign="top" style="padding: 0 10px;">
                                            <img src="https://i.pinimg.com/236x/f9/d5/40/f9d540cbc40cbf24d633f7f248ca7d47.jpg" width="170" width="170" alt="alt_text" border="0" class="center-on-narrow">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                            <!-- Column : BEGIN -->
                            <td width="66.66%" class="stack-column-center">
                                <table class="" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td dir="ltr" valign="top" style="font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555; padding: 10px; text-align: left;" class="center-on-narrow">
                                            <strong style="color:#111111;">Solo Ristoranti selezionati nel nostro sito</strong>
                                            <br><br>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                            <br><br>
                                            <!-- Button : Begin -->
                                            <table cellspacing="0" cellpadding="0" border="0" class="center-on-narrow" style="float:left;">
                                                <tr>
                                                    <td style="border-radius: 3px; background: #222222; text-align: center;" class="button-td">
                                                        <a href="http://localhost:8000/" style="background: #222222; border: 15px solid #222222; font-family: sans-serif; font-size: 13px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
						                                    &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#ffffff">Vai al sito</span>&nbsp;&nbsp;&nbsp;&nbsp;
						                                </a>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- Button : END -->
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- Thumbnail Left, Text Right : END -->

            <!-- Thumbnail Right, Text Left : BEGIN -->
            <tr>
                <td dir="rtl" align="center" valign="top" width="100%" style="padding: 10px;">
                    <table  class="shadow-table" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <!-- Column : BEGIN -->
                            <td width="33.33%" class="stack-column-center">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td dir="ltr" valign="top" style="padding: 0 10px;">
                                            <img src="https://i.pinimg.com/236x/1d/2b/9f/1d2b9f99440d1686ceee7b6b9a4c2e66.jpg" width="170" width="170" alt="alt_text" border="0" class="center-on-narrow">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                            <!-- Column : BEGIN -->
                            <td width="66.66%" class="stack-column-center">
                                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td dir="ltr" valign="top" style="font-family: sans-serif; font-size: 15px; mso-height-rule: exactly; line-height: 20px; color: #555555; padding: 10px; text-align: left;" class="center-on-narrow">
                                            <strong style="color:#111111;">Con i prodotti migliori</strong>
                                            <br><br>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                            <br><br>
                                            <!-- Button : Begin -->
                                            <table cellspacing="0" cellpadding="0" border="0" class="center-on-narrow" style="float:left;">
                                                <tr>
                                                    <td style="border-radius: 3px; background: #222222; text-align: center;" class="button-td">
                                                        <a href="http://localhost:8000/" style="background: #222222; border: 15px solid #222222; font-family: sans-serif; font-size: 13px; line-height: 1.1; text-align: center; text-decoration: none; display: block; border-radius: 3px; font-weight: bold;" class="button-a">
						                                    &nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#ffffff">Vai al sito</span>&nbsp;&nbsp;&nbsp;&nbsp;
						                                </a>
                                                    </td>
                                                </tr>
                                            </table>
                                            <!-- Button : END -->
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <!-- Column : END -->
                        </tr>
                    </table>
                </td>
            </tr>
            <!-- Thumbnail Right, Text Left : END -->

        </table>
        <!-- Email Body : END -->

        <!-- Email Footer : BEGIN -->
        {{-- <table cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container">
            <tr>
                <td style="padding: 40px 10px;width: 100%;font-size: 12px; font-family: sans-serif; mso-height-rule: exactly; line-height:18px; text-align: center; color: #888888;">
                    <br><br>
                    Deliveboo<br><span class="mobile-link--footer">2347 via casa nostra, IT </span><br><span class="mobile-link--footer">(339) 34923873434</span>
                </td>
            </tr>
        </table> --}}
        <!-- Email Footer : END -->

    </center>
</body>
</html>
