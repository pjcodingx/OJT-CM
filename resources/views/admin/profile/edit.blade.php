{{--! FOR ADMIN EDITING OF PROFILE --}}

<form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Name</label>
    <input type="text" name="name" value="{{ auth()->user()->name }}">

    <label>Email</label>
    <input type="email" name="email" value="{{ auth()->user()->email }}">



    <label>Upload Profile Photo</label>
    <input type="file" name="photo">

    @if (session('success'))
    <div style="color: green; margin-bottom: 10px;">
        {{ session('success') }}
    </div>
@endif


    <button type="submit">Update Profile</button>
</form>

