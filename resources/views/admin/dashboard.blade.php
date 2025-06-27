<h1>THIS IS THE DASHBOARD FOR ADMIN</h1>

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit">Logout</button>
</form>
