<nav class="main-header navbar navbar-expand-md navbar-light navbar-lightblue">
    <div class="container">
        <a href="/" class="navbar-brand"
           style="display: flex; align-items: center; justify-content: center; height: 100%; ">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="brand-image elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">{{ config('app.name', 'Admin-IT') }}</span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                @role('AdminXXXX')
                <li class="nav-item">
                    <a href="/dashboards" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i> Dashboard</a>
                </li>
                @endrole
                <li class="nav-item dropdown">
                    <a id="chequesMenu" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Cheques</a>
                    <ul aria-labelledby="chequesMenu" class="dropdown-menu border-0 shadow">
                        <li class="nav-item">
                            <a href="/cheques" class="nav-link">Liste</a>
                            <a href="/cheques.upload" class="nav-link">Telecharger</a>
                        </li>
                        <!-- End Level two -->
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a id="encaissementsMenu" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Encaissements ARIS</a>
                    <ul aria-labelledby="encaissementsMenu" class="dropdown-menu border-0 shadow">
                        <li class="nav-item">
                            <a href="/encaissements" class="nav-link">Liste</a>
                            <a href="/encaissements.upload" class="nav-link">Telecharger</a>
                        </li>
                        <!-- End Level two -->
                    </ul>
                </li>
                @role('AdminXXX')
                <li class="nav-item dropdown">
                    <a id="traitementsMenu" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Traitements</a>
                    <ul aria-labelledby="traitementsMenu" class="dropdown-menu border-0 shadow">
                        <li class="nav-item">
                            <a href="/" class="nav-link">Liste</a>
                        </li>
                        <!-- End Level two -->
                    </ul>
                </li>
                @endrole

                @canany(['workflow-list','enumtype-list'])
                <li class="nav-item dropdown">
                    <a id="workflowsMenu" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Workflows</a>
                    <ul aria-labelledby="workflowsMenu" class="dropdown-menu border-0 shadow">
                        @can('workflow-list')
                        <li class="nav-item">
                            <a href="/workflows" class="nav-link">Liste</a>
                        </li>
                        @endcan
                        @can('enumtype-list')
                        <li class="dropdown-submenu dropdown-hover">
                            <a id="enumtypesMenu" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Types Composés</a>
                            <ul aria-labelledby="enumtypesMenu" class="dropdown-menu border-0 shadow">
                                <li class="nav-item">
                                    <a href="/enumtypes" class="nav-link">Liste</a>
                                    @can('enumtype-create')
                                    <a href="/enumtypes/create" class="nav-link">Nouveau</a>
                                    @endcan
                                </li>
                            </ul>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                @role('Admin')
                <li class="nav-item dropdown">
                    <a id="usersMenu" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Utilisateurs</a>
                    <ul aria-labelledby="usersMenu" class="dropdown-menu border-0 shadow">
                        <li class="nav-item">
                            <a href="/users" class="nav-link">Liste</a>
                        </li>
                        <li class="dropdown-submenu dropdown-hover">
                            <a id="rolesMenu" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Profiles</a>
                            <ul aria-labelledby="rolesMenu" class="dropdown-menu border-0 shadow">
                                <li class="nav-item">
                                    <a href="/roles" class="nav-link">Liste</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                @endrole

                @role('Admin')
                <li class="nav-item dropdown">
                    <a id="remindersMenu" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Reminders</a>
                    <ul aria-labelledby="remindersMenu" class="dropdown-menu border-0 shadow">
                        <li class="nav-item">
                            <a href="/reminders" class="nav-link">List</a>
                        </li>
                        <li class="nav-item">
                            <a href="/reminderobjects" class="nav-link">Objects</a>
                        </li>
                    </ul>
                </li>
                @endrole

                @role('Admin')
                <li class="nav-item dropdown">
                    <a id="systemsMenu" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">System</a>
                    <ul aria-labelledby="systemsMenu" class="dropdown-menu border-0 shadow">
                        <li class="nav-item">
                            <a href="/systems.index" class="nav-link">Index</a>
                        </li>
                    </ul>
                </li>
                @endrole
            </ul>

            <!-- SEARCH FORM -->
{{--            @include('layouts.admin02.nav.search')--}}
        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <!-- Messages Dropdown Menu -->
{{--        @include('layouts.admin02.nav.messages')--}}

        <!-- Notifications Dropdown Menu -->
{{--            @include('layouts.admin02.nav.notifications')--}}
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i class="fas fa-th-large"></i></a>
            </li>
        </ul>
    </div>
</nav>
