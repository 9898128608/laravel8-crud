<!DOCTYPE html>
<html>

<head>
    @include('comman.head')
</head>

<body>
    <div class="container-fluid">
        <h2 class="text-center mt-5">All Patients</h2>
        <div class="container">

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @elseif(session('failed'))
                <div class="alert alert-danger" role="alert">
                    {{ session('failed') }}
                </div>
            @endif


            <a href="{{ route('addPatient') }}" class="btn btn-outline-primary">Add New Patient<a> <br /><br />
                    <div class="row">
                        <table id='empTable' class="table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>S.no</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact No</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#empTable').DataTable({
                processing: true,
                serverSide: true, 
                "aoColumnDefs": [
                    { "bSortable": false, "aTargets": [ 0, 1, 2, 3, 4, 5 ] }, 
                    { "bSearchable": false, "aTargets": [ 0, 1, 2, 3, 4, 5 ] }
                ],
                sDom: 'Lfrtlip',
                language: { search: "" },
                ajax: "{{ route('getPatients') }}",
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'contact_no'
                    },
                    {
                        data: 'category'
                    },
                    {
                        data: 'action'
                    },
                ]
            });

        });
    </script>
</body>

</html>
