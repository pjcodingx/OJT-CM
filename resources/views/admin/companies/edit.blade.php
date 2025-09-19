@extends('layouts.admin')

@section('styles')
<style>
    .company-create-form {
        max-width: 900px;
        margin: 0 auto;
        background-color: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        font-family: Verdana, sans-serif;
    }

    .company-create-form h2 {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #006400;
        text-align: center;
    }

    .company-create-form .form-group {
        margin-bottom: 20px;
    }

    .company-create-form label {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
        color: #14532d;
    }

    .company-create-form input,
    .company-create-form select {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 2px solid #ccc;
        border-radius: 6px;
        font-family: Verdana, sans-serif;
        color: #1b4332;
    }

    .company-create-form input:focus,
    .company-create-form select:focus {
        border-color: #006400;
        outline: none;
        box-shadow: 0 0 0 2px rgba(0, 100, 0, 0.2);
    }

    .company-create-form button[type="submit"] {
        background-color: #044d04;
        color: white;
        padding: 10px 16px;
        font-size: 16px;
        font-weight: 600;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin: 20px auto 0;
        display: block;
        width: 200px;
        text-align: center;
        transition: background-color 0.3s ease;
    }

    .company-create-form button[type="submit"]:hover {
        background-color: #004d00;
    }

    .input-wrapper {
        position: relative;
        width: 100%;
    }

    .input-field {
        width: 100%;
        padding: 10px 40px 10px 10px;
        font-size: 14px;
        border: 2px solid #ccc;
        border-radius: 6px;
        font-family: Verdana, sans-serif;
    }

    .toggle-password {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        border: none;
        background: none;
        font-size: 16px;
        color: #555;
    }

    .password-row {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
    }

    .password-col {
        flex: 1;
        min-width: 250px;
    }

    .alert-error {
        background-color: #fee2e2;
        color: #991b1b;
        padding: 10px;
        border-radius: 6px;
        margin-top: 10px;
        font-size: 14px;
    }

    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
        padding: 10px;
        border-radius: 6px;
        margin-top: 10px;
        font-size: 14px;
    }
</style>
@endsection

@section('content')
<div class="company-create-form">
    <h2>Edit Company</h2>

    <form action="{{ route('admin.companies.update', $company->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="name" value="{{ old('name', $company->name) }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $company->email) }}" required>
        </div>

        <div class="password-row">
            <div class="form-group password-col">
                <label>Password</label>
                <div class="input-wrapper">
                    <input type="password" name="password" id="password" class="input-field" placeholder="Enter new password">
                    <button type="button" class="toggle-password" onclick="toggleVisibility('password', this)">👁</button>
                </div>
            </div>

            <div class="form-group password-col">
                <label>Confirm Password</label>
                <div class="input-wrapper">
                    <input type="password" name="password_confirmation" id="password_confirmation" class="input-field" placeholder="Confirm password">
                    {{-- <button type="button" class="toggle-password" onclick="toggleVisibility('password_confirmation', this)">👁</button> --}}
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" value="{{ old('address', $company->address) }}">
        </div>

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <button type="submit">Update</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function toggleVisibility(id, btn) {
        const input = document.getElementById(id);
        if (input.type === 'password') {
            input.type = 'text';
            btn.textContent = '👁';
        } else {
            input.type = 'password';
            btn.textContent = '👁';
        }
    }
</script>
@endsection
