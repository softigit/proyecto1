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


    <title>M&amp;U Mobile</title>
     <SCRIPT language="javascript">

          function addRow(tableID) {

               var table = document.getElementById(tableID);

 

               var rowCount = table.rows.length;

               var row = table.insertRow(rowCount);

 

               var cell1 = row.insertCell(0);

               var element1 = document.createElement("input");

               element1.type = "checkbox";

               cell1.appendChild(element1);

 

               var cell2 = row.insertCell(1);

               var element2 = document.createElement("input");
               var nuevo =rowCount+1;   
			   
			   element2.type = "text";
			   element2.id = "text"+nuevo;
               element2.name = "text"+nuevo;
			   element2.setAttribute('class', 'ui-input-text ui-body-c');
             
			  //v1.appendChild(document.createTextNode('texto del vinculo')); 

			   cell2.appendChild(element2);

          }

 

          function deleteRow(tableID) {

               try {

               var table = document.getElementById(tableID);

               var rowCount = table.rows.length;

 

               for(var i=0; i<rowCount; i++) {

                    var row = table.rows[i];

                    var chkbox = row.cells[0].childNodes[0];

                    if(null != chkbox && true == chkbox.checked) {

                         table.deleteRow(i);

                         rowCount--;

                         i--;

                    }

               }

               }catch(e) {

                    alert(e);

               }

          }

 

     </SCRIPT>

</HEAD>

<BODY>
<div data-role='page' data-theme='chase' id='contacto'>
<div class='header' data-backbtn='false' data-role='header' data-theme='chase'>
          <div class='logo'></div>
          <a class='top-left-link home' data-icon='home' href='menu.php'>Inicio</a>
        </div>
        <div class='content' data-role='content'>
          <h2>Cotización</h2>
          <ul data-inset='true' data-role='listview' data-theme='d'>
          <li>
 <form action="popup.php" id="form1" name="form1" method="post">

     <INPUT type="button" value="Add Row" onclick="addRow('dataTable');" />

 

     <INPUT type="button" value="Delete Row" onclick="deleteRow('dataTable');" />

 

     <TABLE id="dataTable">

          <TR>

               <TD><!-- <INPUT type="checkbox" NAME="chk"/> --></TD>

               <TD> 
               <a href="#popupNested" data-rel="popup" data-role="button" data-inline="true" data-icon="bars" data-theme="b" data-transition="pop">
               <INPUT type="text" id="text1" name="text1" /> 
               </a>
               </TD>

          </TR>

     </TABLE>
     <input type="submit" id="submit" name="submit" value="envar"/>
</form>
 <div data-role="popup" id="popupNested" data-theme="none">
					<div data-role="collapsible-set" data-theme="b" data-content-theme="c" data-collapsed-icon="arrow-r" data-expanded-icon="arrow-d" style="margin:0; width:250px;">
						<div data-role="collapsible" data-inset="false">
							<h2>Equipo Split</h2>
							<ul data-role="listview">
								<li><a href="../dialog.html" data-rel="dialog">9.000 BTU</a></li>
								<li><a href="../dialog.html" data-rel="dialog">12.000 BTU</a></li>
								<li><a href="../dialog.html" data-rel="dialog">18.000 BTU</a></li>
                                <li><a href="../dialog.html" data-rel="dialog">24.000 BTU</a></li>
								<li><a href="../dialog.html" data-rel="dialog">36.000 BTU</a></li>
							</ul>
						</div><!-- /collapsible -->
						<div data-role="collapsible" data-inset="false">
							<h2>Equipo Cassette</h2>
							<ul data-role="listview">
								<li><a href="../dialog.html" data-rel="dialog">9.000 BTU</a></li>
								<li><a href="../dialog.html" data-rel="dialog">12.000 BTU</a></li>
								<li><a href="../dialog.html" data-rel="dialog">18.000 BTU</a></li>
                                <li><a href="../dialog.html" data-rel="dialog">24.000 BTU</a></li>
								<li><a href="../dialog.html" data-rel="dialog">36.000 BTU</a></li>
							</ul>
						</div><!-- /collapsible -->
						<div data-role="collapsible" data-inset="false">
							<h2>Equipo Piso Cielo</h2>
							<ul data-role="listview">
								<li><a href="../dialog.html" data-rel="dialog">18.000 BTU</a></li>
                                <li><a href="../dialog.html" data-rel="dialog">24.000 BTU</a></li>
								<li><a href="../dialog.html" data-rel="dialog">36.000 BTU</a></li>
                                <li><a href="../dialog.html" data-rel="dialog">36.000 BTU</a></li>
							</ul>
						</div><!-- /collapsible -->
						<div data-role="collapsible" data-inset="false">
							<h2>Equipo Ventana</h2>
							<ul data-role="listview">
								<li><a href="../dialog.html" data-rel="dialog">12.000 BTU</a></li>
                        	</ul>
						</div><!-- /collapsible -->
						
                        <div data-role="collapsible" data-inset="false">
							<h2>Otros</h2>
							<ul data-role="listview">
								<li><a href="../dialog.html" data-rel="dialog">Bomba de condensado</a></li>
								<li><a href="../dialog.html" data-rel="dialog">Punto eléctrico Monofásico</a></li>
								<li><a href="../dialog.html" data-rel="dialog">Punto eléctrico Trifásico</a></li>
								<li><a href="../dialog.html" data-rel="dialog">Zebra</a></li>
							</ul>
						</div><!-- /collapsible -->
					</div><!-- /collapsible set -->
				</div><!-- /popup -->




 </li>
 </ul>
 </div>
 </div>
 


</BODY>

</html>