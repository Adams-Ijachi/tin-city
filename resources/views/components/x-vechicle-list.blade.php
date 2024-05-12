<div>
    <ul class="menu-list">

        @foreach ($vehicles as $vehicle)
            <li class="--set-active-tables-html">
                <a >
                    <span class="icon"><i class="mdi mdi-car-back"></i></span>
                    <span class="menu-item-label">
                        {{ $vehicle->name  }}
                    </span>
                </a>
            </li>

        @endforeach

    </ul>
</div>