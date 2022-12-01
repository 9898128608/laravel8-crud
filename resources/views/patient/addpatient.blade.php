<!DOCTYPE html>
<html>

<head>
    @include('comman.head')
</head>

<body>



    <div class="container-fluid">
        <h2 class="text-center mt-5">

            @if ($edit == true)
                Edit Patient
            @else
                Add Patient
            @endif


            {{-- {{ $document }} --}}

        </h2>
        <div class="container">


            <form action="{{ route('insertPatient') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if ($edit == true)
                    <input type="hidden" name="id" value="{{ $patient->id }}">
                @endif


                <div class="row">
                    <div class="form-group col-md-6 mb-2">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name"
                            value="@if ($edit == true) {{ $patient->name }} @endif">


                        @if ($errors->has('name'))
                            <span class="invalid-feedback d-block">
                                {{ $errors->first('name') }}
                            </span>
                        @endif


                    </div>
                    <div class="form-group col-md-6  mb-2">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" id="email"
                            value="@if ($edit == true) {{ $patient->email }} @endif">


                        @if ($errors->has('email'))
                            <span class="invalid-feedback d-block">
                                {{ $errors->first('email') }}
                            </span>
                        @endif

                    </div>
                    <div class="form-group col-md-6  mb-2">
                        <label class="form-label">Contact No</label>
                        <input type="text" class="form-control" name="contact_no" id="contact_no"
                            value="@if ($edit == true) {{ $patient->contact_no }} @endif">

                        @if ($errors->has('contact_no'))
                            <span class="invalid-feedback d-block">
                                {{ $errors->first('contact_no') }}
                            </span>
                        @endif


                    </div>



                    <div class="form-group col-md-6 mb-2">
                        <label class="form-label">Uplaod Documents</label>
                        <input type="file" class="form-control" name="files[]" id="file" multiple>
                    </div>




                    @if ($edit == true)
                        @if ($patient->documents && !$patient->documents->isEmpty())
                            <div class="row flex mt-4">
                                @foreach ($patient->documents as $singledocument)
                                    <div class="col-md-2 col-sm-2">
                                        <div class="thumbnail">
                                            <img src="{{ $singledocument->PatientDocumentLink }}"
                                                style="height: 300%;width:50%">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endif





                    <div class="row mt-5">
                        <div class="col-sm-1">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                        <div class="col-sm-1">
                            <a href="{{ route('listing') }}" class="btn btn-secondary btn-md">Back<a>
                        </div>
                    </div>


                </div>
            </form>

        </div>
    </div>
</body>

</html>
