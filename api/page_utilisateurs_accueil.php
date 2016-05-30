<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>:: API TWEEVENT ::</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
<div id="wrapper">
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="adjust-nav">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="actions.php?action=Accueil">


                </a>

            </div>

                <span class="logout-spn" >
                  <a href="#" style="color:#fff;">Déconnexion</a>

                </span>
        </div>
    </div>
    <!-- /. NAV TOP  -->
    <nav class="navbar-default navbar-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="main-menu">

                <li class="active-link">
                    <a href="actions.php?action=Accueil" ><i class="fa fa-desktop "></i>Accueil </a>
                </li>
            </ul>
        </div>

    </nav>
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper" >
        <div id="page-inner">
            <table>
                <thead>
                <tr>
                    <th>Option</th>
                    <th>Default</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><strong>showSpeed</strong></td>
                    <td>15</td>
                    <td>The speed of the show/reveal</td>
                </tr>
                <tr>
                    <td><strong>showEasing</strong></td>
                    <td>'linear'</td>
                    <td>The easing of the show/reveal</td>
                </tr>
                <tr>
                    <td><strong>hideSpeed</strong></td>
                    <td>50</td>
                    <td>The speed of the hide/conceal</td>
                </tr>
                <tr>
                    <td><strong>hideEasing</strong></td>
                    <td>'linear'</td>
                    <td>The easing of the hide/conceal</td>
                </tr>
                <tr>
                    <td><strong>width</strong></td>
                    <td>'auto'</td>
                    <td>The width that the data will be truncated to - <em>('auto' or px amount)</em></td>
                </tr>
                <tr>
                    <td><strong>ellipsis</strong></td>
                    <td>true</td>
                    <td>Set to true to enable the ellipsis</td>
                </tr>
                <tr>
                    <td><strong>title</strong></td>
                    <td>false</td>
                    <td>Set to true to show the full data on hover</td>
                </tr>
                <tr>
                    <td><strong>afterShow</strong></td>
                    <td> $.noop</td>
                    <td>The callback fired after the show/reveal</td>
                </tr>
                <tr>
                    <td><strong>afterHide</strong></td>
                    <td>$.noop</td>
                    <td>The callback fired after the hide/conceal</td>
                </tr>
                </tbody>
            </table>

        <!-- /. PAGE INNER  -->
    </div>
    <!-- /. PAGE WRAPPER  -->
</div>
<div class="footer">


    <div class="row">
        <div class="col-lg-12" >
            &copy;  2016 | D�velopp� par : <a href="http://twitter.com/xVirusproj3ct_" style="color:#fff;" target="_blank">xVirusproj3ct</a>
        </div>
    </div>
</div>


<!-- /. WRAPPER  -->
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="assets/js/custom.js"></script>


</body>
</html>
