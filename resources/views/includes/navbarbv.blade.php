<div>
    <b-navbar toggleable="lg" type="light" style="background-color: #e74c3c;">
        <b-navbar-brand href="/home">{{env('APP_NAME')}}</b-navbar-brand>

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>









            <b-navbar-nav  >


                {{--Responsables--}}

                    <b-nav-item-dropdown text="Mes Gymnastes" right >
                        <b-dropdown-item href="/responsable/gymnastes/">Liste</b-dropdown-item>
                        <b-dropdown-item href="/responsable/gymnastes/add">Ajouter</b-dropdown-item>

                    </b-nav-item-dropdown>


                @if (session()->has('admin'))
                    <b-nav-item-dropdown text="Admin" right>
                        <b-dropdown-header>Gymnastes</b-dropdown-header>
                        <b-dropdown-item href="/admin/gymnastes/">Consulter</b-dropdown-item>


                        <b-dropdown-divider></b-dropdown-divider>
                        <b-dropdown-header>Equipes</b-dropdown-header>
                        <b-dropdown-item href="/admin/equipes/">Consulter</b-dropdown-item>


                        <b-dropdown-divider></b-dropdown-divider>
                        <b-dropdown-header>Technique</b-dropdown-header>
                        <b-dropdown-item href="/admin/passport">API</b-dropdown-item>

                    </b-nav-item-dropdown>
                @endif



            </b-navbar-nav>

            <!-- Right aligned nav items -->
            <b-navbar-nav class="ml-auto">




                <b-nav-item-dropdown right>
                    <!-- Using 'button-content' slot -->
                    <template slot="button-content"><em>{{ Auth::user()->email }}</em></template>
                    <b-dropdown-item href="#">Profile</b-dropdown-item>
                    <b-dropdown-item href="{{route('logout')}}">Déconnexion</b-dropdown-item>
                </b-nav-item-dropdown>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</div>