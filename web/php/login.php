<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Introduzca un usuario válido</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body class="fondoautentica" onload="javascript: document.getElementById('txtUsuario').focus();">
<header>
        <div class="cargatec">            
            <img src="../media/donkey.png" style="height:100px;display:flex;text-align:left;">
            CargaTec 
        </div>
        <div class="logotec">
            <img src="../media/logotec-removebg-preview.png" style="height:100px;display:flex;">
        </div>  
</header>
<form id="frmAutentica" name="frmAutentica" action="../php/qryLogin.php" method="post">
    <div class="recuadroIngreso">
        <div class="ingreso">
            <table align="center" border="1" style="background-color: rgba(255, 255, 255, 0.845);">
                <tr>
                    <td colspan="2" align="center"><h2 class="fuenteUsuario">Introduzca su usuario</h2></td>
                </tr>
                <tr>
                    <td class="fuente">Usuario</td>
                    <td align="left">
                        <div class="input-container">
                            <input type="text" id="txtUsuario" name="txtUsuario" maxlength="10" size="50">
                            <div class="error-message">Se requiere este dato</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="fuente"><font class="fuenteUsuario">Contraseña</font></td>
                    <td align="left">
                        <div class="input-container">
                            <input type="password" id="txtPwd" name="txtPwd" maxlength="10" size="50">
                            <div class="error-message">Se requiere este dato</div>
                        </div>
                    </td>
                </tr>
            </table>
            <table align="center" border="1" style="background-color: rgba(255, 255, 255, 0.845);">
                        <tr>
                            <td>
                                <input  class="submit"
                                        type="submit"
                                        value="Enviar"
                                        id="btnEnviar"
                                        name="btnEnviar"
                                        style="width: 100px;"
                                        onclick="validaForma()" >
                            </td>
                            <td align="center">
                              <input type="button" value="Cancelar" id="btnCancelar" style="width: 100px;">
                            </td>
                        </tr>
                        <tr height="60px">
                            <td colspan="2">
                                <font color="red">
                                    <div id="msgError"></div>
                                </font>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
    </form>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery.validate.js"></script>
<script type="text/javascript">
    function validaForma(){
        $("#frmAutentica").validate({
            rules: {
                txtUsuario: "required",
                txtPwd: "required"
            },
            messages: {
                txtUsuario: "Se requiere este dato.",
                txtPwd: "Se requiere este dato."
            },

            submitHandler: function(form) {
                $.ajax({
                    url: frmAutentica.action,
                    type: frmAutentica.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        $('#msgError').html(response);
                    }
                });
            }
        });
    }
    </script>
    <script src="../js/script.js"></script>
    </body>
    </html>