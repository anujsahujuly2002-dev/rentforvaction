 <div class="topnav" id="myTopnav">
    <a href="{{ route('owner.dashboard') }}" @if(request()->route()->getName()=='owner.dashboard') class="active" @endif>Dashboard</a>
    <a href="{{ route('owner.myprofile') }}" @if (request()->route()->getName()=='owner.myprofile')
        class="active"
    @endif>My Profile</a>
    <a href="{{ route('owner.property.create') }}" @if (request()->route()->getName()=='owner.property.create')
        class="active"
    @endif>My Properties</a>
    {{-- <a href="javascript:void(0)">Specials/Deals</a> --}}
    <a href="javascript:void(0)">Inquiries</a>
    <a href="javascript:void(0);" class="icon" onclick="myFunction()">
        <i class="fa fa-bars"></i>
    </a>
    <a href="javascript:void(0);" onclick="logout()">LogOut</a>
</div>
