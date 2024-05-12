
@extends('layout')
@section('content')

<div id="app">


    <aside class="aside is-placed-left is-expanded">
        <div class="aside-tools">
            <div>
                Admin <b class="font-black">One</b>
            </div>
        </div>
        <div class="menu is-menu-main">

            <p class="menu-label">Vehicles</p>
            <x-x-vechicle-list
                    :vehicles="$vehicles"
            />

        </div>
    </aside>

    <section class="is-title-bar">
        <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
            <ul>
                <li>Admin</li>
                <li>Dashboard</li>
            </ul>
        </div>
    </section>


    <section class="section main-section">
        <div class="grid gap-6 grid-cols-1 md:grid-cols-3 mb-6">
            <div class="card">
                <div class="card-content">
                    <div class="flex items-center justify-between">
                        <div class="widget-label">
                            <h3>
                                Vehicles
                            </h3>
                            <h1>
                                {{ count($vehicles) }}
                            </h1>
                        </div>
                        <span class="icon widget-icon text-green-500"><i class="mdi mdi-car-back mdi-48px"></i></span>
                    </div>
                </div>
            </div>


        </div>

        <div class="card">
            <div class="card-content">
                <div class="flex items-center justify-between">

                    MAP
                </div>
            </div>
        </div>

    </section>

</div>
@endsection



