<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="nav-icon la la-chart-line"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-user"></i> Manage Users </a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('usergroup') }}'><i class='nav-icon la la-user-friends'></i> User Groups</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('client') }}'><i class='nav-icon la la-user'></i> Clients</a></li>
    </ul>
</li>

<li class='nav-item'><a class='nav-link' href='{{ backpack_url('shop') }}'><i class='nav-icon la la-store'></i> Shops</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('payment') }}'><i class='nav-icon la la-dollar-sign'></i> Payments</a></li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-handshake"></i> Manage Rentals </a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('rental') }}'><i class='nav-icon la la-handshake'></i> Rentals</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('penalty') }}'><i class='nav-icon la la-id-card-alt'></i> Penalties</a></li>
    </ul>
</li>

<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-bicycle"></i> Manage Bikes </a>
    <ul class="nav-dropdown-items">
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('bike') }}'><i class='nav-icon la la-bicycle'></i> Bikes</a></li>
        <li class='nav-item'><a class='nav-link' href='{{ backpack_url('bikecategory') }}'><i class='nav-icon la la-cubes'></i> Bike Categories</a></li>
    </ul>
</li>



<li class='nav-item'><a class='nav-link' href='{{ backpack_url('advertisement') }}'><i class='nav-icon la la-ad'></i> Advertisements</a></li>