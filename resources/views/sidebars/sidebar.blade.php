<div class="collapse navbar-collapse sidebar d-flex flex-column align-items-start" id="navbarNavDropdown">

    <!-- Sidebar -->
    <div id="sidebar-container" class="sidebar-expanded d-none d-md-block">
        <!-- d-* hiddens the Sidebar in smaller devices. Its itens can be kept on the Navbar 'Menu' -->
        <!-- Bootstrap List Group -->
        <ul class="list-group">






            <!-- Separator with title -->
            <li class="list-group-item sidebar-separator-title menu-collapsed">
                Responsable/Parent
            </li>
            <!-- /END Separator -->
            <!-- Menu with submenu -->



            <a href="/responsable/gymnastes" class="bg-light list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-tasks fa-fw mr-3"></span>
                    <span class="menu-collapsed">Mes Gymnastes</span>
                </div>
            </a>


            <!-- Separator with title -->
            <li class="list-group-item sidebar-separator-title d-flex align-items-center menu-collapsed">
                OPTIONS
            </li>
            <!-- /END Separator -->
            <a href="#" class="bg-light list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-calendar fa-fw mr-3"></span>
                    <span class="menu-collapsed">Calendar</span>
                </div>
            </a>
            <a href="#" class="bg-light list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="fa fa-envelope-o fa-fw mr-3"></span>
                    <span class="menu-collapsed">Messages <span class="badge badge-pill badge-primary ml-2">5</span></span>
                </div>
            </a>
            <a href="/admin/api" class="bg-light list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-start align-items-center">
                    <span class="far fa-eye fa-fw mr-3"></span>
                    <span class="menu-collapsed">API</span>
                </div>
            </a>

            @if (session()->has('admin'))
                <!-- Separator with title -->
                    <li class="list-group-item sidebar-separator-title d-flex align-items-center menu-collapsed">
                        ADMINISTRATEUR
                    </li>
                    <a href="/admin/gymnastes" class="bg-light list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-start align-items-center">
                            <span class="fa fa-users mr-3"></span>
                            <span class="menu-collapsed">Adhérents</span>
                        </div>
                    </a>

                    <a href="/admin/passport" class="bg-light list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-start align-items-center">
                            <span class="fa fa-key mr-3"></span>
                            <span class="menu-collapsed">Oauth</span>
                        </div>
                    </a>

            @endif



        </ul>
    </div>
</div>
