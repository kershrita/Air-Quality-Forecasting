<style>
.active{
    font-weight: 500;
}
</style>
<nav class="navbar navbar-expand-lg  navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{route("dashboard")}}">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ isActiveRoute(['dashboard']) }}" aria-current="page" href="{{route("dashboard")}}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ isActiveRoute(['dashboard2']) }}" href="{{route("dashboard2")}}">Grouping for data</a>
                </li>
            </ul>
        </div>
    </div>

</nav>
