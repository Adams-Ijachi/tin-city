
@extends('layout')
@section('content')



        <section class="is-title-bar">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0">
                <ul>
                    <li>Admin</li>
                    <li>Dashboard</li>
                </ul>
            </div>
        </section>


        <section class="section main-section">


            <div class="card">
                <div class="card-content">
                    <div class=" items-center justify-between">

                        MAP
                        <div id="map">
                            <google-map :center="{lat:40, lng:40}" :zoom="7" style="width:100% ; height: 320px" />
                            <map-test  />
                        </div>
                    </div>
                </div>
            </div>

        </section>




@endsection



