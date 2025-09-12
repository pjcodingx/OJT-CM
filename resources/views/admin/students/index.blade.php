@extends('layouts.admin')

@section('content')

<style>
    tr{
        color: black;
    }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .page-header h2 {
        font-size: 24px;
        font-weight: bold;
        color:black;
    }

    .add-btn {
        background-color: #28a745;
        color: #fff;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
    }

    .filters {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .filters input,
    .filters select {
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;

    }



    .table-container {
        margin-top: 20px;
        overflow-x: auto;

    }

    .student-table {
        width: 100%;
        border-collapse: collapse;

    }

    .student-table th,
    .student-table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
        font-size: 14px;
        vertical-align: middle;
        text-align: center;
    }

    .student-table th {
        background-color: #064e17;
        color: #fff
    }

    .action-btn {
        margin-right: 5px;
        padding: 5px 8px;
        font-size: 14px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;


    }

    .edit-btn {
        background-color: #17a2b8;
        color: white;
    }

    .delete-btn {
        background-color: #dc3545;
        color: white;
    }

    .qr-btn {
        background-color: #007bff;
        color: white;
        width: 120px;
    }

    .actions-inline {
    display: flex;
    justify-content: center;
    gap: 5px;
    align-items: center;
    flex-wrap: wrap;
}

.action-btn {
    padding: 6px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}


    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.6);
    }

    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border-radius: 8px;
        width: 300px;
        text-align: center;
    }

    .modal-content img {
        width: 100%;
        height: auto;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        margin-top: -10px;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }


.pagination-wrapper {
    text-align: center;
    margin-top: 30px;
    font-family: Verdana, sans-serif;
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


.page-item.disabled .page-link {
    background-color: #5c7f6e;
    color: #ccc;
    cursor: not-allowed;
}


.page-indicator .page-link.static {
    background-color: transparent;
    color: #98afa2;
    font-weight: bold;
    cursor: default;
    padding: 10px 0;
    border: none;
    opacity: 0.5;
}

tbody tr:hover {
        background-color: #d1e7dd;
    }




 object {
        border: 1px solid #ccc;
        padding: 3px;
        background: #fff;
        border-radius: 6px;
        transition: transform 0.2s ease;
    }
    object:hover {
        transform: scale(1.1);
    }
    .download-btn {
        background-color: #28a745;
        color: white;
        padding: 4px 8px;
        border: none;
        border-radius: 4px;
        margin-top: 4px;
        cursor: pointer;
    }


    .search-button {
    padding: 10px 20px;
    background-color: #2e7d32;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 15px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.search-button:hover {
    background-color: #1b5e20;
}


.btn-success {
    background-color: #02643d;
    color: #fff;
    border: none;
    padding: 8px 14px;
    border-radius: 4px;
    font-size: 14px;
    font-weight: bold;
    text-decoration: none;
    display: inline-block;
    cursor: pointer;
    transition: background-color 0.2s ease;
    margin-top: 15px;
}
.btn-success:hover {
    background-color: #03ce87;
}

.btn-red {
    background-color: #b02a37;
    color: #fff;
    border: none;
    padding: 8px 14px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    font-weight: bold;
    text-decoration: none;
    display: inline-block;
    transition: background-color 0.2s ease;
}

.btn-red:hover {
    background-color: #d63343;
}


</style>





<div class="filters">


    {{-- ?ADDED THIS FOR FILTERING COURSE --}}

        <form method="GET" action="{{ route('admin.students.index') }}" style="margin-bottom: 20px;">
    <div style="display: flex; gap: 10px; align-items: center;">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search by name or email"
            style="padding: 14px; width: 250px;"
        >


        <select name="course_id" onchange="this.form.submit()" style="padding: 14px;">
            <option value=""> Filter by Course </option>
            @foreach($courseCounts as $course)
                <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                    {{ $course->name }} ({{ $course->students_count }})
                </option>
            @endforeach
        </select>

         <select name="status" onchange="this.form.submit()" style="padding: 14px;">
            <option value="">Filter by Status</option>
            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Disabled</option>
        </select>

        <button type="submit" class="search-button">Search</button>
        <div style="margin-bottom: 15px;">

            <a href="{{ route('admin.students.export.excel', request()->query()) }}" class="btn btn-success">Export to Excel</a>

            <a href="{{ route('admin.students.export.pdf', request()->query()) }}" class="btn btn-red">Export to pdf</a>
        </div>





        </div>
    </form>

</div>

<div class="table-container">
    <table class="student-table">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Company</th>
                <th>OJT Adviser</th>
                <th>Status</th>
                <th>QR Code</th>
                <th>Total Hours</th>
                <th>Action</th>

        </thead>
        <tbody>

            @foreach($students as $student)
            <tr>
                <td>{{ $student->id }}</td>
                <td>{{ $student->name }}</td>
                <td>{{ $student->email }}</td>
                <td>{{ $student->course->name ?? 'Not Assigned' }}</td>

                <td>{{ $student->company->name ?? '--'}}</td>
                <td>{{ $student->faculty->name ?? '--'}}</td>
                 <td>
                    @if ($student->status)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Disabled</span>
                    @endif
                </td>
                <td>
                    @if ($student->qr_code_path)
                    <a href="{{ asset('storage/' . $student->qr_code_path) }}" target="_blank">
                        <img src="{{ asset('storage/' . $student->qr_code_path) }}"
                            alt="QR Code"
                            width="60"
                            height="60"
                            style="cursor: zoom-in; border: 1px solid #ccc;">
                    </a>

                    <br>
                    <a href="{{ asset('storage/' . $student->qr_code_path) }}" download>
                        <button class="download-btn">Download</button>
                    </a>
                @else
                    <span style="color: red;">No QR</span>
                @endif

                </td>
                <td>{{ $student->required_hours }}</td>


                <td>
                    <form action="{{ route('admin.students.toggleStatus', $student->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        @if ($student->status)
                            <!-- Active student -> show red disable button -->
                            <button type="submit" class="btn-red">Disable</button>
                        @else
                            <!-- Disabled student -> show green activate button -->
                            <button type="submit" class="btn-success">Activate</button>
                        @endif
                    </form>
                </td>




            @endforeach
            </tr>
        </tbody>
    </table>
</div>

<div class="pagination-wrapper">
    {{ $students->withQueryString()->links('vendor.pagination.prev-next-only') }}
</div>









<div id="qrModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <img id="qrPreview" src="" alt="QR Preview">
    </div>
</div>

@endsection

@section('scripts')

<script>
    function showModal(src) {
        document.getElementById('qrPreview').src = src;
        document.getElementById('qrModal').style.display = "block";
    }

    function closeModal() {
        document.getElementById('qrModal').style.display = "none";
    }


    window.onclick = function(event) {
        if (event.target == document.getElementById('qrModal')) {
            closeModal();
        }
    }
</script>


