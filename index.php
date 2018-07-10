<?php
require_once('Connections/conexion1.php'); 
require_once('funciones.php');
if ( is_session_started() === TRUE) session_destroy();
    $usuario= revisarCookie();
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0" name="viewport" />     
    <meta charset="ISO-8859-1" />
    <meta name="apple-mobile-web-app-capable" content="yes" /> 
    <link href="lib/jquery.mobile-1.3.2.min.css" rel="stylesheet" />
    <script src="lib/jquery-1.9.1.min.js"></script>
    <script src="lib/jquery.mobile-1.3.2.min.js"></script>
    <link href="themes/chase/chase.css" rel="stylesheet" />
    <link href="lib/jquery.mobile.datebox.1.4.0.min.css" rel="stylesheet"  />
    <title>DEMO MANTENCION</title>  
  </head>
  <body>
    <script>
      document.getElementById("startup-loader").style.display = "block";
    </script>
    <div class='everything hide' style='display:none'>
      <div data-role='page' data-theme='chase' id='logon'>
        <div class='content' data-role='content'>
          <h2 class='log-on-title'></h2>
          <form autocomplete='off' data-ajax='false' method='POST' action="recuperarClave.php" name="form3" id ="form3" novalidate>
          </form>
          <form autocomplete='off' data-ajax='false' method='POST' action="cruce.php?a=1" name="form1" id ="form1" novalidate>
            <div class='form-wrapper ui-corner-all ui-listview ui-listview-inset ui-shadow'>
              <div class='form-element'>
                <label aria-hidden='true' for='userid' id='logon-userid'>
                  usuario
                </label>
                <input aria-labelledby='logon-userid' autocapitalize='off' autocomplete='off' id='userid' name='userid' type='text' value='<?php echo $usuario;?>'>
              </div>
              <div class='form-element'>
                <label aria-hidden='true' for='logon-password' id='logon-user-password'>
                  <?php echo "Password";?>
                </label> 
                <input aria-labelledby='logon-user-password' autocomplete='off' id='logon-password' name='logon-password' type='password' value=''>
                  <input type="hidden" name="a" value="1" id ="a">
                  <input type="hidden" name="auth_contextId" id="auth_contextId" value="login" />
                <!--
                <H6 class="ui-link" style="color:#009" ><a href="recuperarClave.php" s class="ui-link-inherit" >olvid&oacute; su clave?</a></H6>
                 --> 
              </div>
            </div>
            <!--       
            <div class='form-wrapper logon-slider-row ui-corner-all ui-listview ui-listview-inset ui-shadow'>
              <div class='ui-grid-a'>
                <div class='ui-block-a'>
                  <label aria-hidden='true' for='logon-slider'>Recordar Usuario</label>
                </div>
                <div class='ui-block-b'>
                  <select aria-hidden='true' data-role='slider' data-theme='d' id='logon-slider' name='logon-slider' style='float:right'>
                    <option aria-hidden='true' value='off'>Off</option>
                    <option aria-hidden='true' value='on'>On</option>
                  </select>
              <?php if ($usuario!="") { ?>
               <script type="text/javascript">
        var selectFunction = function() {
            document.getElementById("logon-slider").value = "on";
        };
		selectFunction();
    </script>
              
              
              <?php } ?>
                </div>
              </div>
            </div>
          -->
            <button aria-label='Log' data-theme='chase' name='log' role='button'  value='submit' onclick="form1.submit()">
              <span aria-hidden='true'>ACCESO</span>
            </button>
          </form>      
      </div>
     <script>
      $('.everything').removeClass('hide');
      $('.everything > div').unwrap();
      $('#startup-loader').remove();
    </script>
              
</body>
</html>