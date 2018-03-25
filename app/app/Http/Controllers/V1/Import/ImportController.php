<?php

namespace App\Http\Controllers\V1\Import;

use App\Http\Controllers\V1\Controller;
use App\Repositories\ContactRepository;
use App\Repositories\EmployeeRepository;
use App\Services\Imports\CSVImportService;
use App\Traits\UserRequest;
use Illuminate\Http\Request;
use League\Csv\Exception;

class ImportController extends Controller
{
    use UserRequest;

    protected $contacts;
    protected $employees;

    public function __construct(ContactRepository $contacts, EmployeeRepository $employees)
    {
        $this->middleware('jwt.auth');
        $this->contacts = $contacts;
        $this->employees = $employees;
    }

    /**
     * Get Repository
     * @param string $name
     * @return ContactRepository|EmployeeRepository
     */
    private function getRepository(string $name)
    {
        switch ($name) {
            case 'contacts':
                return $this->contacts;
                break;
            case 'employees':
                return $this->employees;
                break;
        }
    }

    public function process(Request $request)
    {
        $file = $request->file('file');
        $repositoryName = $request->input('repository', 'contacts');
        $org = $request->input('org_id');
        $repository = $this->getRepository($repositoryName);

        $name = md5(rand(0, time())).'.csv';
        $file->storeAs('tmp/imports', $name);

        $csvImporter = new CSVImportService($name, $repository, $this->requestUser());

        try {
            $csvImporter
                ->setOrgID($org)
                ->process();

            return response()->json([
                'status' => 'success',
                'message' => 'Data imported successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error parsing csv file'
            ]);
        }
    }
}