@extends('dashboard.layouts.master')
<style>
    .main-box-navy .left-all-links ul li a.subscribers-active,
    .main-box-navy .left-all-links ul li a:hover {
        background-color: white;
        font-weight: 600;
    }

    .main-box-navy .left-all-links ul li a.subscribers-active span,
    .main-box-navy .left-all-links ul li a:hover span {
        background-color: #2CC374;
    }

    .main-box-navy .left-all-links ul li a.subscribers-active span img,
    .main-box-navy .left-all-links ul li a:hover span img {
        filter: invert(0) hue-rotate(465deg) brightness(10.5);
    }
</style>
</head>
@section('content')
    <div class="col-lg-10">
        <div class="main-calendar-box main-calendar-box-list customers-box">
            <div class="two-things-align" bis_skin_checked="1">
                <h5>Subscribers</h5>
            </div>
        </div>
        <div class="main-table-box main-table-box-list services-table">
            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>
                            <div class="align-box">
                                <div class="input-box-check">
                                    <input type="checkbox">
                                </div>
                                <p>ID</p>
                            </div>
                        </th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subscribers as $subscriber)
                        <tr>
                            <td>
                                <div class="align-box">
                                    <div class="input-box-check">
                                        <input type="checkbox">
                                    </div>
                                    <p>{{ $subscriber->id }}</p>
                                </div>
                            </td>
                            <td>{{ $subscriber->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection

<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function() {
    $('#myTable').DataTable({
        dom: 'Bfrtip', // This is required to enable the buttons
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});

</script>
