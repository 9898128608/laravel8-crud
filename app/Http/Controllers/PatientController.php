<?php

namespace App\Http\Controllers;

use App\Http\Requests\patient\CreatePatienRequest;
use App\Models\Patient;
use App\Models\PatientDocument;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Patient\PatientDocumentRepository;
use App\Repositories\Patient\PatientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    protected $patientRepository;
    protected $patientdocumentRepository;
    protected $categoryRepository;
    
    function __construct(
        PatientRepository $patientRepository,
        PatientDocumentRepository $patientdocumentRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->patientRepository = $patientRepository;
        $this->patientdocumentRepository = $patientdocumentRepository;
        $this->categoryRepository = $categoryRepository;

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
        //$columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $columnSortOrder = 'desc'; // asc or desc

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
                "category" => null,
                "action" => "<a href='" . route('addPatient', $id) . "'  class='btn btn-outline-primary'  >Edit</a>  <a href='" . route('destroyPatient', $id) . "' class='btn btn-outline-secondary' >Delete</a>"
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
        $category_array = array();
        $edit = false;

        if ($id) {
            $edit = true;
            $params = array();
            $params['id'] = $id;
            $params['with'] = ['documents']; 
            $patient = $this->patientRepository->getByParams($params);
             
            if (empty($patient)) {

                return redirect()->route('listing');
            }
        }

        //$category_array['id'] = $id;
        $categoryData = $this->categoryRepository->getByParams('select');
        //dd($categoryData);
         
        return view('patient.addpatient')->with(['patient' => $patient, 'edit' => $edit, 'category' => $categoryData]);
    }

    public function insertPatient(CreatePatienRequest $request)
    {

        $params = array();
        $params['id'] = $request->input('id');
        $params['name'] = $request->input('name');
        $params['email'] = $request->input('email');
        $params['contact_no'] = $request->input('contact_no');
        $params['category'] = $request->input('category');
        $patient = $this->patientRepository->save($params);
        // dd($patient->id);

        if ($request->has('files')) {
            $Documents = $request->file('files');
            foreach ($Documents as $document) {
                $uploadPath = config('custom.upload.patients.documents');
                $name = getName($document);
                $path = $uploadPath . '/' . $name;
                $disk = getDisk();
                Storage::disk($disk)->put($path, file_get_contents($document));

                $params = array();
                $params['patient_id'] =  $patient->id;
                $params['name'] =  $name;
                $params['path'] =  $path;
                $patient_document = $this->patientdocumentRepository->save($params);
            }
        }

        if ($request->input('id') && $request->input('id') > 0) {
            return redirect()->route('listing')->with('status', 'Patient Updated successfully.');
        } else {
            return redirect()->route('listing')->with('status', 'Patient Inserted successfully.');
        }
    }

    public function destroyPatient($id)
    {
        $result = $this->patientRepository->delete($id);
        return redirect()->route('listing')->with('status', 'Patient Delete successfully.');
    }

    public function deletePatientDocument($id)
    {
        $result = $this->patientdocumentRepository->delete($id);
        return redirect()->route('listing')->with('status', 'Patient Delete successfully.');
    }
}
