@extends('layouts.faculty')

@section('content')
<style>
    body {
        font-family: Arial, sans-serif;
        color: black;
    }

    .container {
        max-width: 1400px;
        margin: 5px auto;
        padding: 20px;
    }

    h2 {
        margin-bottom: 20px;
    }

    .search-bar {
        margin-bottom: 20px;
    }

    .search-bar:hover {
        color: green;
    }

    .search-bar input {
        padding: 8px;
        width: 300px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        background-color: #fefefe;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
        font-size: 14px;
    }

    th {
        background-color: #004d40;
        color: white;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    .btn-view {
        padding: 6px 12px;
        background-color: #00695c;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 13px;
    }

    .btn-view:hover {
        background-color: #004d40;
    }


    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        padding-top: 50px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.7);
    }

    .modal-content {
        background-color: #fff;
        margin: auto;
        padding: 30px;
        border: 1px solid #888;
        width: 80%;
        max-width: 800px;
        border-radius: 8px;
        color: black;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 26px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover {
        color: black;
    }

    .attachment-preview img {
        max-width: 200px;
        margin-right: 10px;
        margin-top: 10px;
    }

    .pdf-link {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 12px;
        background-color: #f3f3f3;
        border: 1px solid #ccc;
        text-decoration: none;
        color: #333;
        border-radius: 4px;
        font-size: 14px;
    }

    .download-btn{
        border-radius: 30px;
        background: #004d40;
        color: white;
    }

      .pagination-wrapper {
        text-align: center;
        margin-top: 30px;
    }

    .pagination {
        list-style: none;
        padding: 0;
        margin: 0;
        display: inline-flex;
        align-items: center;
        gap: 15px;
    }

    .pagination .page-item {
        display: inline-block;
    }

    .page-link {
        display: inline-block;
        padding: 10px 20px;
        background-color: #14532d;
        color: #fff;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .page-link:hover {
        background-color: #1e7c43;
        transform: translateY(-1px);
    }
</style>

<div class="container">
    <h2>Journal Submissions</h2>
    <form method="GET" action="{{ route('faculty.journals.index') }}" style="display: flex; gap: 10px; margin-bottom: 20px;">
        <input type="text" name="search" placeholder="Search by student name..." value="{{ request('search') }}" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px; color: black;">

        <input type="date" name="date" value="{{ request('date') }}" style="padding: 8px; border: 1px solid #ccc; border-radius: 4px; color: black;">

        <button type="submit" style="background-color: #004d40; color: white; border: none; padding: 8px 12px; border-radius: 4px;">
            Filter
        </button>
    </form>

@if(session('success'))
    <div style="color:green; font-weight:bold; margin-bottom:10px;">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div style="color:red; font-weight:bold; margin-bottom:10px;">
        {{ session('error') }}
    </div>
@endif



    <table id="journalTable">
        <thead>
            <tr>
                <th>Student</th>
                <th>Email</th>
                <th>Company</th>
                <th>Location</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($journals as $journal)
                <tr>
                    <td>{{ $journal->student->name }}</td>
                    <td>{{ $journal->student->email }}</td>
                    <td>{{ $journal->student->company->name ?? 'N/A' }}</td>
                    <td>{{ $journal->student->company->address ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($journal->journal_date)->format('F j, Y') }}</td>
                    <td>{{ $journal->created_at->format('g:i A') }}</td>
                    <td>
                        @if($journal->status == 'Late')
                            <span style="color:red; font-weight:bold;">Late</span>
                        @else
                            <span style="color:green; font-weight:bold;">On Time</span>
                        @endif
                    </td>


                    <td>
                        <div style="display: flex; gap: 5px; align-items: center;">
                            <button class="btn-view" onclick="openModal({{ $journal->id }})">View</button>

                            @if($journal->status == 'Late')
                                <form action="{{ route('faculty.journals.penalty', $journal->id) }}" method="POST" style="display:flex; gap: 5px; align-items:center; margin:0;">
                                    @csrf
                                    <input type="number" name="penalty_hours" min="0.1" step="0.1" max="1" placeholder="min" style="width:50px; height:28px; padding:2px 4px; border-radius:4px; border:1px solid #ccc;">
                                    <button type="submit" class="btn-view" style="background-color: #b71c1c; margin:0; padding:4px 8px;">
                                        Deduct
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>




@foreach ($journals as $journal)
    <div id="modal-{{ $journal->id }}" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal({{ $journal->id }})">&times;</span>
            <h3>Journal of {{ $journal->student->name }}</h3>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($journal->journal_date)->format('F j, Y') }}</p>
            <p><strong>Time Submitted:</strong> {{ $journal->created_at->format('g:i A') }}</p>
            <hr><br>
            <p><strong>Content:</strong><br>{{ $journal->content }}</p><br><br>

            @if ($journal->attachments->count())
                <h4>Attachments:</h4>
                <div class="attachment-preview">
                    @foreach ($journal->attachments as $attachment)
                        @if (in_array($attachment->file_type, ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                            <img src="{{ asset('storage/' . $attachment->file_path) }}" alt="Image">
                        @else
                            <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="pdf-link" class="download-btn" style="background: #004d40; border-radius: 30px; color: white;">
                                📄 Download {{ strtoupper($attachment->file_type) }}
                            </a><br>
                        @endif
                    @endforeach
                </div>
            @else
                <p style="color:red;"><em>No attachments.</em></p>
            @endif
        </div>
    </div>
@endforeach

<div class="pagination-wrapper">
    {{ $journals->withQueryString()->links('vendor.pagination.prev-next-only') }}
</div>

<script>
    function openModal(id) {
        document.getElementById('modal-' + id).style.display = 'block';
    }

    function closeModal(id) {
        document.getElementById('modal-' + id).style.display = 'none';
    }


    document.getElementById('searchInput').addEventListener('keyup', function () {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#journalTable tbody tr');

        rows.forEach(function (row) {
            let name = row.children[0].textContent.toLowerCase();
            row.style.display = name.includes(filter) ? '' : 'none';
        });
    });




</script>
@endsection
