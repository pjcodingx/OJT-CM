<h1>WELCOME TO COMPANY DASHBOARD</h1>

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
