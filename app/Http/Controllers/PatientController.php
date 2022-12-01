<?php

namespace App\Http\Controllers;

use App\Http\Requests\patient\CreatePatienRequest;
use App\Models\Patient;
use App\Repositories\Patient\PatientRepository;
use Illuminate\Http\Request; 

class PatientController extends Controller
{
    protected $patientRepository;
    function __construct(
        PatientRepository $patientRepository
    ) {
        $this->patientRepository = $patientRepository;
    }

    public function listing()
    {

        return view('patient.listing');
    }

    function getPatients(Request $request)
    {

        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Patient::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Patient::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = Patient::orderBy($columnName, $columnSortOrder)
            ->where('name', 'like', '%' . $searchValue . '%')
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $id = $record->id;
            $contact_no = $record->contact_no;
            $name = $record->name;
            $email = $record->email;

            $data_arr[] = array(
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "contact_no" => $contact_no,
                "action" => "<a href='".route('addPatient',$id)."'  class='link-primary'  >Edit</a> | <a href='".route('destroyPatient',$id)."' class='link-danger' >Delete</a>"
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);
    }

    public function addPatient($id = null)
    {
        $patient = array();
        $edit = false;

        if ($id) {
            $edit = true;
            $params = array();
            $params['id'] = $id;
            $patient = $this->patientRepository->getByParams($params);
        }
        
        return view('patient.addpatient')->with(['patient' => $patient, 'edit' => $edit]);
    }

    public function insertPatient(CreatePatienRequest $request)
    {

        $params = array();
        $params['id'] = $request->input('id');
        $params['name'] = $request->input('name');
        $params['email'] = $request->input('email');
        $params['contact_no'] = $request->input('contact_no');
        $patient = $this->patientRepository->save($params);
        if($request->input('id') && $request->input('id') > 0) {
            return redirect()->route('listing')->with('status', 'Patient Updated successfully.');
        }else{
            return redirect()->route('listing')->with('status', 'Patient Inserted successfully.');
        }
    }

    public function destroyPatient($id)
    {
        $result = $this->patientRepository->delete($id);
        return redirect()->route('listing')->with('status', 'Patient Delete successfully.');

    }

    
}
