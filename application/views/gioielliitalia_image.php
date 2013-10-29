<html>
    <head>
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900,300italic,400italic,600italic,700italic,900italic' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="/Gioielli-Italia/assets/css/image_admin.css">
        <link rel="stylesheet" href="/Gioielli-Italia/assets/css/style.css">
        <!-- Loading: Normalize, Grid and Styles -->
        <link rel="stylesheet" href="/Gioielli-Italia/assets/css/normalize.css" media="screen">
        <link rel="stylesheet" href="/Gioielli-Italia/assets/css/qbkl-grid.css" media="screen">
        <link rel="stylesheet" href="/Gioielli-Italia/assets/css/style.css" media="screen">


        <!-- Loading: Font Awesome -->
        <link rel="stylesheet" href="/Gioielli-Italia/assets/font-awesome/css/font-awesome.min.css">
        <!--[if IE 7]>
        <link rel="stylesheet" href="/Gioielli-Italia/assets/font-awesome/css/font-awesome-ie7.min.css">
        <![endif]-->

        <!-- Loading: jQuery Magnific Popup Stylesheet -->
        <link rel="stylesheet" href="/Gioielli-Italia/assets/js/magnific/jquery.magnific-popup.css" media="screen">

        <!-- Loading: jQuery Easy Pie Chart Stylesheet -->
        <link rel="stylesheet" href="/Gioielli-Italia/assets/js/easy-pie/jquery.easy-pie-chart.css" media="screen">

        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body>
        <nav id="nav">
            <ul class="clearfix">
                <li><a href="#inserisci">Inserisci Foto</a></li>
                <li><a href="#elimina">Elimina Foto </a></li>
                <li><a id="logout">Logout</a></li>
                <li><a id="aggiorna">Aggiorna</a></li>
            </ul>
        </nav>
        <section id="inserisci" class="section">
            <div class="container">
                <div class="row">
                    <div class="col-full">
                        <h2 class="section-title">Inserisci Foto</h2>
                        <div class="centered line"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-full">
                        <h3 class="section-title">Seleziona la categoria</h3>
                        <div class="centered"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-full">
                        <ul class="filters-adm">
                            <li class="filter-adm" name="gold" data-filter="port-hochzeit">Gold</li>
                            <li class="filter-adm" name="trauringe" data-filter="port-komunion">Trauringe</li>
                            <li class="filter-adm" name="einladungskarten" data-filter="port-taufe_geburt">Einladungskarten</li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-full">
                        <ul class="filters-adm">
                            <li class="filter-adm" name="modeschmuck-damen" data-filter="port-hochzeit">Modeschmuck-damen</li>
                            <li class="filter-adm" name="modeschmuck-herren" data-filter="port-komunion">Modeschmuck-herren</li>
                            <li class="filter-adm" name="taufkleider" data-filter="port-taufe_geburt">Taufkleider</li>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-full">
                        <ul class="filters-adm">
                            <li class="filter-adm" name="bomboniere-hochzeit" data-filter="port-hochzeit">Hochzeit</li>
                            <li class="filter-adm" name="bomboniere-komunion" data-filter="port-komunion">Komunion</li>
                            <li class="filter-adm" name="bomboniere-taufe_geburt" data-filter="port-taufe_geburt">Taufe Geburt</li>
                        </ul>
                    </div>
                </div>
                <div style="display:block;text-align: center">
                    <form id="newHotnessForm" action="./upload" method="post" enctype="multipart/form-data">
                        <label id="lfile">Scegli un'immagine:</label>
                        <input id="ifile" name="file" type="file" size="20" />
                        <input id="type" type="hidden" name="tipo" value=""/>
                        <div align="center"><a href="#" id="addProduct">Salva</a></div>
                    </form>
                </div>
                <div class="col-full" id="block"></div>
            </div>
        </section>
        <section id="elimina" class="section">
            <div class="container">
                <div class="row">
                    <div class="col-full">
                        <h2 class="section-title">Elimina Foto</h2>
                        <div class="centered line"></div>
                    </div>
                </div>
                <div class="row section-content">
                    <!-- Portfolio items -->
                    <div class="row projects gallery">
                        {image_entries}
                        <div class="col-1-6">
                            <img class="imgtodelete" src={thumb} height="150" width="150" alt=""/>
                            <div class="conferma">
                                <button class="conf" type="button" class="btn">conferma</button>
                                <button class="disc" type="button" class="btn">annulla</button>
                            </div>
                        </div>
                        {/image_entries} 
                    </div>
                    <!-- End: Portfolio -->
                </div>
            </div>
        </section>



        <script src="/Gioielli-Italia/assets/js/jquery-1.10.2.min.js"></script>
        <script src="/Gioielli-Italia/assets/js/jquery-migrate-1.2.1.min.js"></script>
        <script src="/Gioielli-Italia/assets/js/jquery.sticky.js"></script>
        <script src="/Gioielli-Italia/assets/js/jquery.form.js"></script>
        <script src="/Gioielli-Italia/assets/js/custom-image.js" type="text/javascript"></script>
        <script src="/Gioielli-Italia/assets/js/jquery.scrollto.min.js"></script>
        <script src="/Gioielli-Italia/assets/js/jquery.nav.js"></script>
        <script src="/Gioielli-Italia/assets/js/custom.curriculum.js" type="text/javascript"></script>
        <!--<script src="/Gioielli-Italia/assets/js/custom.curriculum.js" type="text/javascript"></script>-->


    </body>
</html>