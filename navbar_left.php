 <!-- sidebar -->
            <div class="column col-sm-2 col-xs-1 sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li>
                        <a href="#" data-toggle="offcanvas"
                        class="visible-xs text-center">
                        <i class="glyphicon glyphicon-chevron-right"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav hidden-xs" id="lg-menu">
                <li>
                    <a href="#preferenceModal" role="button"
                    data-toggle="modal">
                    <i class="glyphicon glyphicon-list-alt"></i>
                    Préferences
                </a>
            </li>
            <li>
                <a href="Calendrier">
                    <i class="glyphicon glyphicon-list"></i>
                    Calendrier
                </a>
            </li>
            <?php if($_COOKIE['utilisateur_type']=="pro"){?>
            <li>
                <a id="addEvent" href="#" data-toggle="modal" data-target=".addEvent">
                    <i class="glyphicon glyphicon-paperclip"></i>
                    Ajouter Evenement
                </a>
            </li>
            <?php } ?>

            <li>
                <a href="#">
                    <i class="glyphicon glyphicon-refresh"></i>
                    Refresh
                </a>
            </li>
        </ul>
        <ul class="list-unstyled hidden-xs" id="sidebar-footer">
            <li>
                <a href="#">
                    <h3>Tweevent</h3>
                    <i class="glyphicon glyphicon-heart-empty"></i>
                    Events
                </a>
            </li>
        </ul>

        <!-- tiny only nav-->
        <ul class="nav visible-xs" id="xs-menu">
            <li>
                <a href="#preferenceModal" class="text-center" role="button" data-toggle="modal">
                    <i class="glyphicon glyphicon-list-alt"></i>
                </a>
            </li>
            <li><a href="Calendrier" class="text-center"><i class="glyphicon glyphicon-list"></i></a></li>
            <li><a id="addEvent" href="#" class="text-center" data-toggle="modal" data-target=".addEvent"><i class="glyphicon glyphicon-paperclip"></i></a></li>
            <li><a href="#" class="text-center"><i class="glyphicon glyphicon-refresh"></i></a></li>
        </ul>
    </div>
    <!-- /sidebar -->