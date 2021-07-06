<!doctype html>
<html>

<head>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <link href="{{ asset('bts4/css/email.css') }}" rel="stylesheet">
    <title></title>
    <!--[if (mso 16)]>
    <style type="text/css">
        a {text-decoration: none;}
    </style>
    <![endif]-->
    <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
</head>

<body>
<div class="es-wrapper-color">
    <!--[if gte mso 9]>
    <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
        <v:fill type="tile" color="#efefef"></v:fill>
    </v:background>
    <![endif]-->
    <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
            <td class="esd-email-paddings" valign="top">
                <table cellpadding="0" cellspacing="0" class="es-header" align="center">
                    <tbody>
                    <tr>
                        <td class="esd-stripe" esd-custom-block-id="6021" align="center">
                            <table class="es-header-body" width="600" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                <tr>
                                    <td class="esd-structure es-p20" align="left">
                                        <table width="100%" cellspacing="0" cellpadding="0">
                                            <tbody>
                                            <tr>
                                                <td class="esd-container-frame" width="560" valign="top" align="center">
                                                    <table width="100%" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                        <tr>
                                                            <td class="esd-block-image" align="center" style="font-size:0;"><a href="https://info-app.now/" target="_blank"><img src="https://i.imgur.com/fSh7ATr.png" alt="SER logo" title="SER logo" style="max-width: 500px !important; max-height: 150px !important;padding-bottom: 6% !important;padding-right: 6% !important;"></a></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="es-content" cellspacing="0" cellpadding="0" align="center">
                    <tbody>
                    <tr>
                        <td class="esd-block-text" align="left">
                            <h3 style="color: #666666;">Las siguientes actividades estan por vencer y no han sido revisadas.<br></h3>
                        </td>
                    </tr>
                </table>
                <div class="container" style="text-align: -webkit-center">
                <table style="border: 1px solid !important; border-color: #dee2e6 !important; clear: both !important; margin-top: 3% !important; margin-bottom: 3% !important; border-spacing: 0 !important; border-collapse: separate 1im
                ; max-width: none !important; width: 100%; color: #212529; text-align: center !important;">
                    <thead class="table-header" style="background-color: #055e76 !important; color: white !important; vertical-align: middle; border-color: inherit">
                    <tr>
                        <th scope="col" style="text-transform: uppercase">Actividad</th>
                        <th scope="col" style="text-transform: uppercase">Proyecto</th>
                        <th scope="col" style="text-transform: uppercase">Decisión</th>
                        <th scope="col" style="text-transform: uppercase">Fecha de Vencimiento</th>
                        <th scope="col" style="text-transform: uppercase">Hora de Vencimiento</th>
                    </tr>
                    </thead>
                    <tbody style="display: table-row-group; vertical-align: middle; border-color: inherit">
                    @foreach ($actividades as $item)
                        <td class="td td-center">{{$item->Descripcion}}</td>
                        <td class="td td-center">{{$item->Proyecto}}</td>
                        <td class="td td-center">{{$item->Decision}}
                        <td class="td td-center">
                            <a class="btn btn btn-warning no-href"><i class="fas fa-calendar"></i> Vence: {{$item->Fecha_Vencimiento}}</a>
                        </td>
                        <td class="td td-center">
                            <a class="btn btn btn-warning no-href"><i class="fas fa-hourglass-half"></i> Vence a las: {{$item->Hora_Vencimiento}}</a>
                        </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <table cellpadding="0" cellspacing="0" class="es-footer" align="center">
                    <tbody>
                    <tr>
                        <td class="esd-stripe" esd-custom-block-id="6039" align="center">
                            <table class="es-footer-body" width="600" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                <tr>
                                    <td class="esd-structure es-p20t es-p20b es-p20r es-p20l" align="left">
                                        <table width="100%" cellspacing="0" cellpadding="0">
                                            <tbody>
                                            <tr>
                                                <td class="esd-container-frame" width="560" valign="top" align="center">
                                                    <table width="100%" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                        <tr>
                                                            <td class="esd-block-text es-p15t es-p10b es-p15r es-p15l" align="center">
                                                                <p style="font-size: 14px;">SER.</p>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="esd-footer-popover es-content" cellspacing="0" cellpadding="0" align="center">
                    <tbody>
                    <tr>
                        <td class="esd-stripe" align="center">
                            <table class="es-content-body" style="background-color: transparent;" width="600" cellspacing="0" cellpadding="0" align="center">
                                <tbody>
                                <tr>
                                    <td class="esd-structure es-p30t es-p30b es-p20r es-p20l" align="left">
                                        <table width="100%" cellspacing="0" cellpadding="0">
                                            <tbody>
                                            <tr>
                                                <td class="esd-container-frame" width="560" valign="top" align="center">
                                                    <table width="100%" cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                        <tr>
                                                            <td align="center" class="esd-empty-container" style="display: none;"></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>

</html>

