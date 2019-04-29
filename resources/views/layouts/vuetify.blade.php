<!DOCTYPE html>

<html lang="fr">
<head>
@include('includes.vuetify.head-vuetify')
<!-- Style -->
@yield('style')

</head>

<body>
<div id="app">
    <v-app
            dark
    >








        @auth
            <sidebar></sidebar>
            <navbar title="FJEP Gymnastique" :logged=true></navbar >
        @else
            <navbar title="FJEP Gymnastique" :logged=false></navbar >
        @endauth




    <!-- Page content -->
            <v-content>
                <v-container fill-height>

            @yield('title')


        @yield('content')
                </v-container>
            </v-content>

    </v-app>
</div>

@include('includes.vuetify.foot')
<!-- Scripts -->
@yield('script')
</body>
</html>
