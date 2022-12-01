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


            <a href="{{ route('addPatient') }}" class="btn btn-primary">Add New Patient<a> <br /><br />
                    <div class="row">
                        <table id='empTable' class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <td>S.no</td>
                                    <td>Name</td>
                                    <td>Email</td>
                                    <td>ContactNo</td>
                                    <td>Action</td>
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
                        data: 'action'
                    },
                ]
            });

        });
    </script>
</body>

</html>
