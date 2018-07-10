<?php
session_start();
	         unset($_SESSION["username"]); 
             unset($_SESSION["nivel"]);
             unset($_SESSION["id"]);
             session_destroy();
			 ?>
<!DOCTYPE html>
<html>
<head>

    <meta charset='utf-8'>
   <meta content='width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=0' name='viewport'>
   <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>M&amp;U Mobile</title>
   
   
            <script type='text/javascript'>
              (function(){
              var debugging = /\?.*debug/.test(window.location.href),
                  jsFile = debugging ? 'src/redirect.loader.js' : 'src/redirect.min.js';
              document.write('\x3Cscript type="text/javascript" src="'+jsFile+'">\x3C/script>'); 
            
              if (debugging) {
                document.write('\x3Clink href="lib/jquery.mobile-1.3.2.min.css" rel="stylesheet">');
                document.write('\x3Clink href="themes/chase/chase.css" rel="stylesheet">');
                document.write('\x3Clink href="lib/jquery.mobile.datebox.1.4.0.min.css" rel="stylesheet">');
              } else {
                document.write('\x3Clink href="src/css_files.min.css" rel="stylesheet">');
              }
              }());
            </script>
            
    <link href='themes/chase-apple-touch-icon.png' rel='apple-touch-icon'>
  </head>
 <body>
  
    <noscript>
      <div class='logo' style="background: url('themes/chase/images/chase_header_logo_130.png') no-repeat center center;height: 3em;margin-bottom: .6em;"></div>
      <div style='font: small Arial, Helvetica, sans-serif;'>
        Tu navegador no soporta Javascript, o tiene desactivada la secuencia de código de Javascript. Por favor activela e intente nuevamente, o visite nuestra página HTML <a href="http://www.myu.cl">site</a>.
      </div>
    </noscript>
<div class='ui-page ui-body-chase force-show' id='startup-loader' style='display: none;'>
      <div class='content ui-content'>
        <h2>Cargando M & U...</h2>
      </div>
      <center class='loading-page'>
        <div class='ui-icon-loading spin'></div>
      </center>
    </div>
    <script>
      // Look, Ma! No jQuery!
      document.getElementById("startup-loader").style.display = "block";
    </script>
    <div class='everything hide' style='display:none'>
      <div data-role='page' data-theme='chase' id='home'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Inicio</a>
        </div>
        <div class='content' data-role='content'>
          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <a href='#logon'>
                <div class='menu-icon home-logon-icon ui-li-thumb menu-item-icon'></div>
                <div class='menu-text-with-icon'>
                  Ingresar a Intranet
                </div>
              </a>
            </li>
            <li>
              <a href='#contacto'>
                <div class='menu-icon home-contactus-icon ui-li-thumb menu-item-icon'></div>
                <div class='menu-text-with-icon'>
                  Contáctenos
                </div>
              </a>
            </li>
            <li>
              <a class='location-finder-link' href='#home'>
              <!-- #atmbranchlocations -->
                <div class='menu-icon home-find-atm-branch-icon ui-li-thumb menu-item-icon'></div>
                <div class='menu-text-with-icon'>
                  Cotice con nosotros
                </div>
              </a>
            </li>
            <li>
              <a class='browse-credit-cards-link' href='https://m.creditcards.chase.com/?CELL=64VJ&MSC=CHASEMOBILE'>
                <div class='home-browse-credit-cards-icon ui-li-thumb menu-item-icon'></div>
                <div class='menu-text-with-icon'>
                  Medios de pago
                </div>
              </a>
            </li>
          </ul>
        </div>
        <div class='disclaimers' data-role='footer' data-theme='chase' data-update-page-padding='false' id='home_footer'>
          <!-- <div class='link-to-app'></div> -->
          <ul>
            <li>Intranet de M & U Ltda.</li>
            <li>Diseñado y desarrollado  por M & U Ltda.</li>
            <li>2014</li>
            
          </ul>
        </div>
        
      </div>
      
      
      <div data-role='page' data-theme='chase' id='logon'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Inicio</a>
        </div>
        <div class='content' data-role='content'>
          <h2 class='log-on-title'></h2>
          <form autocomplete='off' data-ajax='false' method='POST' action="siteminder/cruce.php?a=1" name="form1" id ="form1" novalidate>
            <div class='form-wrapper ui-corner-all ui-listview ui-listview-inset ui-shadow'>
              <div class='form-element'>
            
                <label aria-hidden='true' for='userid' id='logon-userid'>Nombre de usuario</label>
                <input aria-labelledby='logon-userid' autocapitalize='off' autocomplete='off' id='userid' name='userid' type='text' value=''>
              </div>
              <div class='form-element'>
                <label aria-hidden='true' for='logon-password' id='logon-user-password'>Password</label>
                <input aria-labelledby='logon-user-password' autocomplete='off' id='logon-password' name='logon-password' type='password' value=''>
                  <input type="hidden" name="a" value="1" id ="a">
              </div>
            </div>
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
                </div>
              </div>
            </div>
            <button aria-label='Log' data-theme='chase' name='log' role='button'  value='submit' onclick="form1.submit()">
              <span aria-hidden='true'>Ingresar Intranet</span>
            </button>
          </form>
          <h2 class='footer-links'>
            <a class='privacy-link' href='#faqs'>FAQs</a>
            <a class='privacy-link' href='#privacymenu'>Privacy</a>
          </h2>
        </div>
        
      </div>
      <div data-role='page' data-theme='chase' id='logonError'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <div class='content' data-role='content'>
          <h2 class='error-title hide'></h2>
          <p class='message'></p>
          <h2>
            <a class='callSupportButton ui-btn ui-shadow ui-btn-corner-all ui-btn-up-chase secondary-button hide' data-corners='true' data-iconshadow='true' data-role='button' data-shadow='true' data-theme='chase' data-wrapperels='span'>
              <span class='ui-btn-inner ui-btn-corner-all'>
                <span class='ui-btn-text'></span>
              </span>
            </a>
            <a class='callCardServices ui-btn ui-shadow ui-btn-corner-all ui-btn-up-chase secondary-button hide' data-corners='true' data-iconshadow='true' data-role='button' data-shadow='true' data-theme='chase' data-wrapperels='span'>
              <span class='ui-btn-inner ui-btn-corner-all'>
                <span class='ui-btn-text'></span>
              </span>
            </a>
            <a class='cancel ui-btn ui-shadow ui-btn-corner-all ui-btn-up-chase secondary-button' data-corners='true' data-iconshadow='true' data-role='button' data-shadow='true' data-theme='chase' data-wrapperels='span' href='#logon'>
              <span class='ui-btn-inner ui-btn-corner-all'>
                <span class='ui-btn-text'></span>
              </span>
            </a>
          </h2>
        </div>
        
      </div>
      <!-- QuickPay Landing page -->
      <div data-role='page' data-theme='chase' id='qp'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Inicio</a>
        </div>
        <div class='content' data-role='content'>
          <h2>
            Welcome to Chase QuickPay
            <sup>
              <small></small>
              SM
            </sup>
          </h2>
          <form autocomplete='off' data-ajax='false' method='POST' novalidate>
            <div class='form-wrapper ui-corner-all ui-listview ui-listview-inset ui-shadow'>
              <div class='qp-logon-info'>
                <span class='bold'>If you already have a Chase User ID and Password, please log on below.</span>
              </div>
              <div class='form-element'>
                <label aria-hidden='true' for='qp-userid' id='logon-qp-userid'>User ID</label>
                <input aria-labelledby='logon-qp-userid' autocapitalize='off' autocomplete='off' id='qp-userid' name='userid' type='text' value=''>
              </div>
              <div class='form-element'>
                <label aria-hidden='true' for='qp-logon-password' id='logon-qp-password'>Password</label>
                <input aria-labelledby='logon-qp-password' autocomplete='off' id='qp-logon-password' name='logon-password' type='password' value=''>
              </div>
            </div>
            <button aria-label='Log On' data-theme='chase' name='logon' role='button' type='submit' value='submit-value'>
              <span aria-hidden='true'>Log On</span>
            </button>
          </form>
          <div class='jpm-note'>
            <span class='bold'>New to Chase QuickPay?</span>
            <span class='normal'>Please enroll using a computer at Chase.com/QP. You must first enroll online in order to send or accept a payment on your mobile device.</span>
            <div class='line-separator'></div>
            <span class='bold'>Note:</span>
            <span class='regular'>J.P. Morgan customers should visit J.P. Morgan Online or access the J.P. Morgan app on their device.</span>
          </div>
          <h2 class='footer-links'>
            <a class='privacy-link' href='#faqs'>FAQs</a>
            <a class='privacy-link' href='#privacymenu'>Privacy</a>
          </h2>
        </div>
        
      </div>
      <!-- QuickPay CXC Routable Login Page -->
      <div data-role='page' data-theme='chase' id='qpselectbank'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <div class='content' data-role='content'>
          <h2>
            Welcome to Chase QuickPay
            <sup>
              <small></small>
              SM
            </sup>
          </h2>
          <div class='left-aligned white-font'>
            <div class='line-separator'></div>
            <span class='bold'>You've received a payment or request.</span>
            <div class='line-separator'></div>
            <span class='bold'>Chase customer and new to Chase QuickPay?</span>
            <span class='normal'>Please enroll using a computer at Chase.com/QP.</span>
            <span class='normal'>You must first enroll online in order to send or accept a payment on your mobile device.</span>
            <div class='line-separator'></div>
            <span class='normal'>If you've received a Chase QuickPay Invoice, you will also need to enroll online to make your payment with our Chase QuickPay service.</span>
          </div>
          <form autocomplete='off' data-ajax='false' method='POST' novalidate>
            <div class='form-wrapper ui-corner-all ui-listview ui-listview-inset ui-shadow'>
              <div class='qp-logon-info'>
                <span class='bold'>You can accept your payment from within your bank's online banking service if your bank is included here:</span>
              </div>
              <div class='form-element'>
                <select data-role='type-select' id='bankredirect' name='bankredirect'>
                  <option value='#'>Select your bank</option>
                  <option value='http://www.bankofamerica.com/getmoney'>Bank of America</option>
                  <option value='https://m.wellsfargo.com/mba/signOn/p2pLandingPage.action'>Wells Fargo</option>
                </select>
              </div>
            </div>
          </form>
          <div class='left-aligned white-font'>
            <span class='bold'>If you bank somewhere else,</span>
            <span class='regular'>sign up online for a free Chase QuickPay account at Chase.com/QP.</span>
            <span class='normal'>(This does not require a Chase account)</span>
            <div class='line-separator'></div>
            <span class='bold'>Note:</span>
            <span class='regular'>J.P. Morgan customers should visit J.P. Morgan Online or access the J.P. Morgan app on their device.</span>
          </div>
          <h2 class='footer-links'>
            <a class='privacy-link' href='#faqs'>FAQs</a>
            <a class='privacy-link' href='#privacymenu'>Privacy</a>
          </h2>
        </div>
        
      </div>
      <!-- logon page for Chase Commercial Online users with RSA token. -->
      <div data-role='page' data-theme='chase' id='cco'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <div class='content' data-role='content'>
          <h2 style='font-size:0.8em'>Chase Commercial Online</h2>
          <h2 class='log-on-title'></h2>
          <form autocomplete='off' data-ajax='false' method='POST' novalidate>
            <div class='form-wrapper ui-corner-all ui-listview ui-listview-inset ui-shadow'>
              <div class='form-element'>
                <label aria-hidden='true' for='userid' id='logon-comm-rsa-userid'>User ID</label>
                <input aria-labelledby='logon-comm-rsa-userid' autocapitalize='off' autocomplete='off' id='cco-userid' name='userid' type='text' value=''>
              </div>
              <div class='form-element'>
                <label aria-hidden='true' for='logon-password' id='logon-comm-rsa-password'>Password</label>
                <input aria-labelledby='logon-comm-rsa-password' autocomplete='off' id='cco-logon-password' name='logon-password' type='password' value=''>
              </div>
              <div class='ui-grid-a logon-slider-row'>
                <div class='ui-block-a'>
                  <label aria-hidden='true' for='logon-slider'>Save User ID</label>
                </div>
                <div class='ui-block-b'>
                  <select data-role='slider' data-theme='d' name='logon-slider' style='float:right'>
                    <option value='off'>Off</option>
                    <option value='on'>On</option>
                  </select>
                </div>
              </div>
              <div class='ui-grid-a logon-slider-row token-slider-row'>
                <div class='ui-block-a'>
                  <label aria-hidden='true' for='token-slider' style='font-size: 0.9em'>I have a security token</label>
                </div>
                <div class='ui-block-b'>
                  <select data-role='slider' data-theme='d' id='token-slider' name='token-slider'>
                    <option value='off'>Off</option>
                    <option value='on'>On</option>
                  </select>
                </div>
              </div>
              <div class='form-element token-info-lable-row hide'>
                <br>
                <label>Wait for your token code to change, then enter the next two sequential codes.</label>
              </div>
              <div class='form-element token-row hide'>
                <label aria-hidden='true' id='cco-token-code'>Token code</label>
                <input aria-labelledby='cco-token-code' autocapitalize='off' autocomplete='off' id='token' name='token' type='tel' value=''>
              </div>
              <div class='form-element next-token-row hide'>
                <label for='next-token'>Next token code</label>
                <input autocapitalize='off' autocomplete='off' id='next-token' name='next-token' type='tel' value=''>
              </div>
            </div>
            <button aria-label='Log On' data-theme='chase' name='logon' role='button' type='submit' value='submit-value'>
              <span aria-hidden='true'>Log On</span>
            </button>
          </form>
          <h2 class='footer-links'>
            <a class='privacy-link' href='#faqs'>FAQs</a>
            <a class='privacy-link' href='#privacymenu'>Privacy</a>
          </h2>
        </div>
        
      </div>
      <!-- logon page for business banking users with RSA token. -->
      <div data-role='page' data-theme='chase' id='bb'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <div class='content' data-role='content'>
          <h2 style='font-size:0.8em'>Chase Online</h2>
          <h2 class='log-on-title'></h2>
          <form autocomplete='off' data-ajax='false' method='POST' novalidate>
            <div class='form-wrapper ui-corner-all ui-listview ui-listview-inset ui-shadow'>
              <div class='form-element'>
                <label aria-hidden='true' for='userid' id='logon-bb-userid'>User ID</label>
                <input aria-labelledby='logon-bb-userid' autocapitalize='off' autocomplete='off' id='bb-userid' name='userid' type='text' value=''>
              </div>
              <div class='form-element'>
                <label aria-hidden='true' for='logon-password' id='logon-bb-password'>Password</label>
                <input aria-labelledby='logon-bb-password' autocomplete='off' id='bb-logon-password' name='logon-password' type='password' value=''>
              </div>
              <div class='ui-grid-a logon-slider-row'>
                <div class='ui-block-a'>
                  <label aria-hidden='true' for='logon-slider'>Save User ID</label>
                </div>
                <div class='ui-block-b'>
                  <select data-role='slider' data-theme='d' name='logon-slider' style='float:right'>
                    <option value='off'>Off</option>
                    <option value='on'>On</option>
                  </select>
                </div>
              </div>
              <div class='ui-grid-a logon-slider-row token-slider-row'>
                <div class='ui-block-a'>
                  <label aria-hidden='true' for='token-slider' style='font-size: 0.9em'>I have a security token</label>
                </div>
                <div class='ui-block-b'>
                  <select data-role='slider' data-theme='d' id='bb-token-slider' name='token-slider'>
                    <option value='off'>Off</option>
                    <option value='on'>On</option>
                  </select>
                </div>
              </div>
              <div class='form-element token-info-lable-row hide'>
                <br>
                <label>Wait for your token code to change, then enter the next two sequential codes.</label>
              </div>
              <div class='form-element token-row hide'>
                <label aria-hidden='true' id='logon-bb-token-code'>Token code</label>
                <input aria-labelledby='logon-bb-token-code' autocapitalize='off' autocomplete='off' id='bb-token' name='token' type='tel' value=''>
              </div>
              <div class='form-element next-token-row hide'>
                <label for='next-token'>Next token code</label>
                <input autocapitalize='off' autocomplete='off' id='bb-next-token' name='next-token' type='tel' value=''>
              </div>
            </div>
            <button aria-label='Log On' data-theme='chase' name='logon' role='button' type='submit' value='submit-value'>
              <span aria-hidden='true'>Log On</span>
            </button>
          </form>
          <h2 class='footer-links'>
            <a class='privacy-link' href='#faqs'>FAQs</a>
            <a class='privacy-link' href='#privacymenu'>Privacy</a>
          </h2>
        </div>
        
      </div>
      <!-- Logon page for Ultimate Rewards -->
      <div class='striped' data-role='page' data-theme='none' id='urlogon'>
        <div class='content' data-role='none'>
          <div class='image-container'>
            <div class='ur-header'></div>
          </div>
          <div class='login-tile'>
            <form autocomplete='off' class='login-form' data-ajax='false' data-role='none' method='POST' novalidate>
              <h2>Welcome</h2>
              <div class='form-wrapper-ur'>
                <div class='control-group'>
                  <label data-role='none' for='userid'></label>
                  <div class='login-input'>
                    <input autocapitalize='off' autocomplete='off' data-role='none' id='ur-userid' name='userid' placeholder='User ID' type='text' value=''>
                  </div>
                </div>
                <div class='control-group'>
                  <label data-role='none' for='logon-password'></label>
                  <div class='login-input'>
                    <input autocomplete='off' data-role='none' id='ur-logon-password' name='logon-password' placeholder='Password' type='password' value=''>
                  </div>
                </div>
                <div class='toggle-holder'>
                  <div class='toggle-slider-side-label'>
                    <label class='toggle-label' data-role='none' id='urToggleLabel'>Save User ID</label>
                    <input aria-labelledby='urToggleLabel' data-role='none' id='saveUserId' name='logon-slider' type='checkbox'>
                    <div class='toggle-container'>
                      <div>
                        <i class='toggle-icon'></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <button aria-label='Log On' class='blue-button' data-role='none' id='urLogon' name='submit' role='button' type='submit' value='submit-value'>
                <span aria-hidden='true'>Log On</span>
              </button>
            </form>
          </div>
        </div>
      </div>
      
      
      <!-- MFA Init -->
      <div data-role='page' data-theme='chase' id='mfa-init'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <div class='mfainit hide'>
          <h2>We don't recognize this mobile device.</h2>
          <div class='content' data-role='content'>
            <h2 class='ui-li-heading left-aligned-heading'>As a precaution, we need to verify your identity in order to give you access to your accounts. All you need to do is request an Identification Code.</h2>
          </div>
          <a class='secondary-button' data-role='button' data-theme='chase' href='#mfachoose'>
            Request an Identification Code
          </a>
          <a class='secondary-button' data-role='button' data-theme='chase' href='#mfaentercode'>
            I have an Identification Code
          </a>
        </div>
      </div>
      <!-- MFA Choose your contact method -->
      <div data-role='page' data-theme='chase' id='mfachoose'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <div class='content' data-role='content'>
          <h2>Request an Identification Code</h2>
          <div id='mfacontactsphone'>
            <script id='TMPL_mfaPhoneList' type='text/x-jquery-tmpl'>
              <ul data-inset='true' data-role='listview' data-theme='d'>
                <li class='mfa-choose-header' data-role='list-divider'>
                  <label>To phone number ${mask}</label>
                </li>
                <li>
                  <a class='textme' href='javascript:void(0);'>Text me</a>
                </li>
                <li>
                  <a class='callme' href='javascript:void(0);'>Call me</a>
                </li>
              </ul>
            </script>
          </div>
          <div id='mfacontactsemail'>
            <script id='TMPL_mfaEmailList' type='text/x-jquery-tmpl'>
              <ul data-inset='true' data-role='listview' data-theme='d'>
                <li class='mfa-choose-header' data-role='list-divider'>
                  <label>To email ${mask}</label>
                </li>
                <li>
                  <a class='emailme' href='javascript:void(0);'>Email me</a>
                </li>
              </ul>
            </script>
          </div>
        </div>
      </div>
      <!-- MFA Enter Identification Code -->
      <div data-role='page' data-theme='chase' id='mfaentercode'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <div class='content' data-role='content'>
          <h2>Enter your Identification Code</h2>
          <form autocomplete='off' data-ajax='false' method='POST' novalidate>
            <div class='form-wrapper ui-corner-all ui-listview ui-listview-inset ui-shadow'>
              <div class='form-element'>
                <label for='idcode'>Identification Code</label>
                <input autocomplete='off' id='idcode' name='idcode' type='tel' value=''>
              </div>
              <div class='form-element'>
                <label for='mfa-password'>Password</label>
                <input autocomplete='off' id='mfa-password' name='mfa-password' type='password' value=''>
              </div>
              <div class='form-element mfa-token-row hide'>
                <label for='mfa-token'>Token code</label>
                <input autocomplete='off' id='mfa-token' name='mfa-token' type='tel' value=''>
              </div>
            </div>
            <button aria-label='Log On' data-theme='chase' name='submit' role='button' type='submit' value='submit-value'>
              <span aria-hidden='true'>Submit</span>
            </button>
          </form>
          <h2>
            <a href='#mfachoose'>Need a new Identification Code?</a>
          </h2>
        </div>
      </div>
      
      
      <!-- ATM/Branch location search page -->
      <div data-role='page' data-theme='chase' id='atmbranchlocations'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <div class='content' data-role='content'>
          <h2>ATM/Branch Locations</h2>
          <a class='secondary-button' data-role='button' data-theme='chase' href='javascript:void(0);' id='automaticGeolocationButton'>Use My Current Location</a>
          <div id='geolocationMsg'></div>
          <form novalidate>
            <div class='form-wrapper ui-corner-all ui-listview ui-listview-inset ui-shadow'>
              <div class='form-element'>
                <label>Chase ATM or branch near you</label>
                <input id='full-address' name='full-address' placeholder='Enter ZIP, or address, city & state.' type='text'>
              </div>
            </div>
            <button class='manualLocationSearch' data-theme='chase' type='submit'>Search</button>
          </form>
        </div>
        
      </div>
      <!-- Display Locations list -->
      <div data-role='page' data-theme='chase' id='locationResults'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <div class='content' data-role='content'>
          <h2>Search Results</h2>
          <ul data-inset='true' data-role='listview' data-theme='d' id='locationsList'></ul>
          <script id='TMPL_locationsList' type='text/x-jquery-tmpl'>
            <li class='${LOCATION_TYPE}'>
              <a class='location-details' href='javascript:void(0)'>
                <div class='atmbranchlocations-info'>
                  <div class='atmbranchlocations-type' data-bubble='yes'>${LOCATION_TYPE}</div>
                  <div class='atmbranchlocations-distance' data-bubble='yes'>${DISTANCE} Miles</div>
                  <p data-bubble='yes'>
                    <div class='atmbranchlocations-name ui-li-desc' data-bubble='yes'>${NAME}</div>
                    <div class='atmbranchlocations-address ui-li-desc' data-bubble='yes'>${ADDRESS}, ${CITY}</div>
                  </p>
                </div>
              </a>
            </li>
          </script>
        </div>
        
      </div>
      <!-- Location details -->
      <div data-role='page' data-theme='chase' id='locationdetailpage'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <div class='content' data-role='content'>
          <div id='locationDetails'></div>
          <script id='TMPL_atmLocationDetails' type='text/x-jquery-tmpl'>
            <h2>${NAME}</h2>
            <ul data-inset='true' data-role='listview' data-theme='d'>
              {{if ADDRESS && CITY && STATE && ZIP}}
              <li>
                <div class='ui-grid-a'>
                  <div class='ui-block-a locations-details-label'>Address</div>
                  <div class='ui-block-b locations-details-value'>
                    <div class='locations-details-address'>${ADDRESS}</div>
                    <div class='locations-details-city-state'>${CITY}, ${STATE}</div>
                    <div class='locations-details-zip'>${ZIP}</div>
                  </div>
                </div>
              </li>
              {{/if}}
              {{if MAPS_URL}}
              <li>
                <a class='mapanddirections' href='${MAPS_URL}' target='${NEW_TAB}'>Map and directions</a>
              </li>
              {{/if}}
            </ul>
            <ul data-inset='true' data-role='listview' data-theme='d'>
              {{if DISTANCE}}
              <li>
                <div class='ui-grid-a'>
                  <div class='ui-block-a locations-details-label'>Distance</div>
                  <div class='ui-block-b locations-details-value'>${DISTANCE} Miles</div>
                </div>
              </li>
              {{/if}}
              {{if ACCESS}}
              <li>
                <div class='ui-grid-a'>
                  <div class='ui-block-a locations-details-label'>Access</div>
                  <div class='ui-block-b locations-details-value'>${ACCESS}</div>
                </div>
              </li>
              {{/if}}
              {{if LANGUAGES}}
              <li>
                <div class='ui-grid-a'>
                  <div class='ui-block-a locations-details-label'>Languages</div>
                  <div class='ui-block-b locations-details-value'>
                    {{each(i, LANGUAGE) LANGUAGES}}
                    <div class='locations-details-language'>${LANGUAGE}</div>
                    {{/each}}
                  </div>
                </div>
              </li>
              {{/if}}
              {{if SERVICES}}
              <li>
                <div class='ui-grid-a'>
                  <div class='ui-block-a locations-details-label'>Services</div>
                  <div class='ui-block-b locations-details-value'>
                    {{each(i, SERVICE) SERVICES}}
                    <div class='locations-details-service'>${SERVICE}</div>
                    {{/each}}
                  </div>
                </div>
              </li>
              {{/if}}
              {{if TYPE}}
              <li>
                <div class='ui-grid-a'>
                  <div class='ui-block-a locations-details-label'>Type</div>
                  <div class='ui-block-b locations-details-value'>${TYPE}</div>
                </div>
              </li>
              {{/if}}
            </ul>
          </script>
          <script id='TMPL_branchLocationDetails' type='text/x-jquery-tmpl'>
            <h2>${NAME}</h2>
            <ul data-inset='true' data-role='listview' data-theme='d'>
              {{if ADDRESS && CITY && STATE && ZIP}}
              <li class='location-details'>
                <div class='ui-grid-a'>
                  <div class='ui-block-a locations-details-label'>Address</div>
                  <div class='ui-block-b locations-details-value'>
                    <div class='locations-details-address'>${ADDRESS}</div>
                    <div class='locations-details-city-state'>${CITY}, ${STATE}</div>
                    <div class='locations-details-zip'>${ZIP}</div>
                  </div>
                </div>
              </li>
              {{/if}}
              {{if PHONE}}
              <li>
                {{if DEVICE_IS_PHONE}}
                <a href='tel:${PHONE}'>
                  <div class='ui-grid-a'>
                    <div class='ui-block-a locations-details-label'>Phone</div>
                    <div class='ui-block-b locations-details-value'>${PHONE}</div>
                  </div>
                </a>
                {{else}}
                <div>
                  <div class='ui-grid-a'>
                    <div class='ui-block-a locations-details-label'>Phone</div>
                    <div class='ui-block-b locations-details-value'>${PHONE}</div>
                  </div>
                </div>
                {{/if}}
              </li>
              {{/if}}
              {{if MAPS_URL}}
              <li>
                <a class='mapanddirections' href='${MAPS_URL}' target='${NEW_TAB}'>Map and directions</a>
              </li>
              {{/if}}
            </ul>
            <ul data-inset='true' data-role='listview' data-theme='d'>
              {{if DISTANCE}}
              <li>
                <div class='ui-grid-a'>
                  <div class='ui-block-a locations-details-label'>Distance</div>
                  <div class='ui-block-b locations-details-value'>${DISTANCE} Miles</div>
                </div>
              </li>
              {{/if}}
              {{if ATMS}}
              <li>
                <div class='ui-grid-a'>
                  <div class='ui-block-a locations-details-label'>ATMs</div>
                  <div class='ui-block-b locations-details-value'>${ATMS}</div>
                </div>
              </li>
              {{/if}}
              {{if LOBBY_HOURS}}
              <li>
                <div class='ui-grid-a'>
                  <div class='ui-block-a locations-details-label'>Lobby</div>
                  <div class='ui-block-b locations-details-value'>
                    {{each(i, HOUR) LOBBY_HOURS}}
                    <div class='locations-details-hours'>${HOUR.DAY}: ${HOUR.HOURS}</div>
                    {{/each}}
                  </div>
                </div>
              </li>
              {{/if}}
              {{if DRIVE_UP_HOURS}}
              <li>
                <div class='ui-grid-a'>
                  <div class='ui-block-a locations-details-label'>Drive-up hours</div>
                  <div class='ui-block-b locations-details-value'>
                    {{each(i, HOUR) DRIVE_UP_HOURS}}
                    <div class='locations-details-hours'>${HOUR.DAY}: ${HOUR.HOURS}</div>
                    {{/each}}
                  </div>
                </div>
              </li>
              {{/if}}
              {{if TYPE}}
              <li>
                <div class='ui-grid-a'>
                  <div class='ui-block-a locations-details-label'>Type</div>
                  <div class='ui-block-b locations-details-value'>${TYPE}</div>
                </div>
              </li>
              {{/if}}
            </ul>
          </script>
        </div>
        
      </div>
      
      
      <!-- Contact Us -->
      <div data-role='page' data-theme='chase' id='contacto'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Inicio</a>
        </div>
        <div class='content' data-role='content'>
          <h2>Contáctenos</h2>
          <ul data-inset='true' data-role='listview' data-theme='d'>
            <li class='phone-link' id='supportTel'>
              <a href='tel:+56978572558'>
                <h3>Servicio Técnico</h3>
                <p>+56 9 7857 2558</p>
              </a>
            </li>
            <li class='phone-link' id='supportTel'>
              <a href='tel:+56973027381'>
                <h3>Ventas</h3>
                <p>+56 9 7302 7381</p>
              </a>
            </li>
            
            <li class='phone-link' id='personalTelPreLogon'>
              <a href='mailto:info@myu.cl'>
                <h3>Correo Electrónico</h3>
                <p>info@myu.cl</p>
              </a>
            </li>
            <!--
            <li class='phone-link hide' id='personalTelPostLogon'>
              <a href='tel:1-800-935-9935'>
                <h3>Personal Checking & Savings</h3>
                <p>1-800-935-9935</p>
              </a>
            </li>
            <li class='phone-link hide' id='cpcPersonalTel'>
              <a href='tel:1-405-235-4847'>
                <h3>International Client Service Line</h3>
                <p>1-405-235-4847</p>
              </a>
            </li>
            <li class='phone-link'>
              <a href='tel:1-800-432-3117'>
                <h3>Personal Credit Cards</h3>
                <p>1-800-432-3117</p>
              </a>
            </li>
            <li>
              <a class='get-more-contacts-button' href='#get-more-contacts-list'>Get More Contacts</a>
            </li>
            -->
          </ul>
        </div>
        
      </div>
      <!-- Get More Contacts List -->
      <div data-role='page' data-theme='chase' id='get-more-contacts-list'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <div class='content' data-role='content'>
          <h2>Contact Us</h2>
          <ul class='get-more-contacts-list' data-inset='true' data-role='listview' data-theme='d'></ul>
          <script class='TMPL_getMoreContactsList' type='text/x-jquery-tmpl'>
            <li>
              <a class='contact-details' href='javascript:void(0);'>
                <h3>${CONTACT_NAME}</h3>
              </a>
            </li>
          </script>
        </div>
        
      </div>
      <!-- Get More Contacts List -->
      <div data-role='page' data-theme='chase' id='get-more-contacts-details'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <div class='content' data-role='content'>
          <h2>Contact Us</h2>
          <ul class='contact-details-container' data-inset='true' data-role='listview' data-theme='d'></ul>
          <script class='TMPL_getMoreContactsDetails' type='text/x-jquery-tmpl'>
            <li data-role='list-divider'>${CONTACT_NAME}</li>
            <li>
              {{each(i, DETAIL) CONTACT_DETAILS}}
              {{if i !== 0}}
              <br>
              {{/if}}
              <div class='contact-detail'>{{html DETAIL}}</div>
              {{/each}}
            </li>
          </script>
        </div>
        
      </div>
      
      
      <!-- Privacy Menu -->
      <div data-role='page' data-theme='chase' id='privacymenu'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <div class='content' data-role='content'>
          <h2>Privacy</h2>
          <ul class='ui-listview' data-inset='true' data-role='listview' data-theme='d'>
            <li>
              <a href='#' id='chasePrivacyPolicy'>
                <h4 class='privacy-menu-label'>Online Privacy Policy</h4>
                <p class='privacy-menu-sublabel'>How we collect, use and protect information from visitors of our U.S. based online services.</p>
              </a>
            </li>
            <li>
              <a href='#privacynotice'>
                <h4 class='privacy-menu-label'>U.S. Consumer Privacy Notice</h4>
                <p class='privacy-menu-sublabel'>How we collect and share customer financial information and ways you can limit our sharing.</p>
              </a>
            </li>
          </ul>
        </div>
        
      </div>
      <!-- Privacy Policy -->
      <div data-role='page' data-theme='chase' id='onlineprivacypolicy'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <div class='content' data-role='content'></div>
        
      </div>
      <!-- Privacy Notice -->
      <div data-role='page' data-theme='chase' id='privacynotice'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <div class='content' data-role='content'>
          <h2>Privacy Notice</h2>
          <div id='privacycontent'>
            <div class='hide privacy-content-div ui-corner-all ui-shadow'></div>
          </div>
        </div>
        
      </div>
      
      
      <!-- Logged Off -->
      <div data-role='page' data-theme='chase' id='loggedoff'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <div class='content' data-role='content'>
          <h2>You have been securely logged off.</h2>
          <br>
          <h2>
            <a href='#logon'>Return to logon</a>
          </h2>
        </div>
      </div>
      
      
      <div data-role='page' data-theme='chase' id='logging-on'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <div class='content' data-role='content'>
          <h2>Esta siendo redirigido a la Intranet. Gracias por su paciencia.</h2>
        </div>
      </div>
      
      
      <!-- HTML Content -->
      <script id='TMPL_htmlcontent' type='text/x-jquery-tmpl'>
        <h2>${TITLE}</h2>
        <div class='htmlcontent'>
          {{html BODY}}
        </div>
      </script>
      
      
      <!-- FAQs -->
      <div data-role='page' data-theme='chase' id='faqs'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Inicio</a>
        </div>
        <div class='content' data-role='content'>
          <h2>FAQs</h2>
          <ul class='faqs-list' data-inset='true' data-role='listview' data-theme='d'></ul>
          <script class='TMPL_faqsList' type='text/x-jquery-tmpl'>
            <li>
              <a class='faqs-topics' href='javascript:void(0);'>
                <h3>${FAQS_TOPIC}</h3>
              </a>
            </li>
          </script>
        </div>
        
      </div>
      <!-- FAQs-Questions -->
      <div data-role='page' data-theme='chase' id='faqs-questions'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <div class='content' data-role='content'>
          <h2 class='faqs-questions-topic'></h2>
          <ul class='faqs-questions-list' data-inset='true' data-role='listview' data-theme='d'></ul>
          <script class='TMPL_faqsQuestionsList' type='text/x-jquery-tmpl'>
            <li>
              <a class='faqs-questions' href='javascript:void(0);'>
                <h3>${QUESTION}</h3>
              </a>
            </li>
          </script>
        </div>
        
      </div>
      <!-- FAQs-Detail -->
      <div data-role='page' data-theme='chase' id='faqs-question-detail'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <div class='content' data-role='content'>
          <h2 class='faqs-questions-topic'></h2>
          <ul class='faqs-question-item ui-listview' data-inset='true' data-role='listview' data-theme='d'></ul>
          <script class='TMPL_faqsQuestionDetail' type='text/x-jquery-tmpl'>
            <li data-role='list-divider'>${QUESTION}</li>
            <li>
              {{each(i, ANS) ANSWERS}}
              {{if i !== 0}}
              <br>
              {{/if}}
              ${ANS}
              {{/each}}
            </li>
          </script>
        </div>
        
      </div>
      
      
      <!-- Agreement Content -->
      <div data-role='page' data-theme='chase' id='moreAgreementContent'>
        <script id='TMPL_moreAgreementContent' type='text/x-jquery-tmpl'>
          <h2>${TITLE}</h2>
          {{if PREVIOUS_URL}}
          <div id='previousVersionButtonGroup'>
            <ul class='content-version'>
              <li>
                <a class='${CURRENT_BUTTON_STYLE}' id='currentVersionButton'>Current Version</a>
              </li>
              <li>
                <a class='${PREVIOUS_BUTTON_STYLE}' id='previousVersionButton'>Previous Version</a>
              </li>
            </ul>
          </div>
          {{/if}}
          <div class='htmlcontent'>
            {{html BODY}}
          </div>
        </script>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <div class='content content-ui-ios' data-role='content'></div>
        
      </div>
      <!-- Agreement Dialog -->
      <div class='ui-page ui-body-chase ui-overlay-a' data-role='page' data-theme='chase' id='agreementDialog' style='min-height: 1104px;'>
        <div class='agreement-flow-overlay'>
          <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
            <div class='logo'></div>
            <a class='top-left-link home' data-icon='home' href='/index.html#home'>Home</a>
          </div>
        </div>
        <div class='ui-dialog-contain ui-corner-all ui-overlay-shadow'>
          <div class='ui-corner-top ui-header ui-bar-d'>
            <h1 class='ui-title' role='heading'>We need your help updating our records</h1>
          </div>
          <div class='content' data-role='content'>
            <p id='agreementDialogText'></p>
            <a class='agreement-dialog-ok-button' data-role='button' data-theme='chase'>OK</a>
          </div>
        </div>
      </div>
      <!-- Agreement Content -->
      <div data-role='page' data-theme='chase' id='agreementContent'>
        <script id='TMPL_agreementContent' type='text/x-jquery-tmpl'>
          <h2>${TITLE}</h2>
          <div class='htmlcontent'>
            {{html BODY}}
          </div>
        </script>
        <div class='agreement-flow-overlay'>
          <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
            <div class='logo'></div>
            <a class='top-left-link home' data-icon='home' href='/index.html#home'>Home</a>
          </div>
        </div>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='/index.html#home'>Home</a>
        </div>
        <div class='content content-ui-ios' data-role='content'></div>
        <div class='agreement-footer content-agree-cancel-group' data-position='fixed' data-role='footer'>
          <ul class='content-version'>
            <li>
              <a class='agreement-footer-cancel-button content-ui-cancel'>Cancel</a>
            </li>
            <li>
              <a class='agreement-footer-ok-button content-ui-agree'>I Agree</a>
            </li>
          </ul>
        </div>
      </div>
      <!-- Confirm Dialog -->
      <div class='ui-page ui-body-chase ui-overlay-a' data-role='page' data-theme='chase' id='agreementConfirm' style='min-height: 1104px;'>
        <div class='agreement-flow-overlay'>
          <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
            <div class='logo'></div>
            <a class='top-left-link home' data-icon='home' href='/index.html#home'>Home</a>
          </div>
        </div>
        <div class='ui-dialog-contain ui-corner-all ui-overlay-shadow'>
          <div class='ui-corner-top ui-header ui-bar-d'>
            <h1 class='ui-title' role='heading'>Confirmation</h1>
          </div>
          <div class='content' data-role='content'>
            <p id='agreementConfirmText'></p>
            <a class='agreement-confirm-continue-button' data-role='button' data-theme='chase'>Continue</a>
            <a class='agreement-confirm-cancel-button cancel secondary-button' data-role='button' data-theme='chase' href='javascript:history.go(-1);'>Cancel</a>
          </div>
        </div>
      </div>
      <!-- Agreement List -->
      <div data-role='page' data-theme='chase' id='agreementList'>
        <div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='#home'>Home</a>
        </div>
        <h2>Legal Agreements</h2>
        <div class='content' data-role='content'>
          <ul data-inset='true' data-role='listview' data-theme='d' id='agreementListContainer'></ul>
          <script class='TMPL_agreementList' type='text/x-jquery-tmpl'>
            <li>
              <a class='agreement-item' href='javascript:void(0);'>
                <h3>${NAME}</h3>
              </a>
            </li>
          </script>
        </div>
        
      </div>
    </div>
   
<script type='text/javascript'>
              (function(){
              var debugging = /\?.*debug/.test(window.location.href),
                  jsFile = debugging ? 'src/index.loader.js' : 'src/index.min.js';
              document.write('\x3Cscript type="text/javascript" src="'+jsFile+'">\x3C/script>');
          debugging=true;
		      if (debugging) {
                document.write('\x3Clink href="lib/jquery.mobile-1.3.2.min.css" rel="stylesheet">');
                document.write('\x3Clink href="themes/chase/chase.css" rel="stylesheet">');
                document.write('\x3Clink href="lib/jquery.mobile.datebox.1.4.0.min.css" rel="stylesheet">');
              } else {
                document.write('\x3Clink href="src/css_files.min.css" rel="stylesheet">');
              }
              }());
            </script>
  
  <script>
      $('.everything').removeClass('hide');
      $('.everything > div').unwrap();
      $('#startup-loader').remove();
    </script>
      
  
</body>
</html>
