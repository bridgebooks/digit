<?php

namespace App\Http\Controllers\V1\Search;

use App\Http\Controllers\V1\Controller;
use App\Repositories\BankRepository;
use App\Repositories\ContactRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $contactRepository;
    protected $userRepository;
    protected $bankRepository;
    protected $employeeRepository;

    public function __construct(
        ContactRepository $contacts,
        UserRepository $userRepository,
        BankRepository $bankRepository,
        EmployeeRepository $employeeRepository)
    {
        $this->contactRepository = $contacts;
        $this->userRepository = $userRepository;
        $this->bankRepository = $bankRepository;
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @param string $index
     * @return ContactRepository|UserRepository|BankRepository|EmployeeRepository
     */
    private function getRepository(string $index)
    {
        switch ($index) {
            case 'contacts':
                return $this->contactRepository;
                break;
            case 'employees':
                return $this->employeeRepository;
                break;
            case 'users':
                return $this->userRepository;
                break;
            case 'banks':
                return $this->bankRepository;
                break;
            default:
                return $this->contactRepository;
                break;
        }
    }

    public function find(Request $request)
    {
        $index = $request->get('index', 'contacts');
        $org_id = $request->get('org_id');

        return $this->getRepository($index)->search($request->search, $org_id);
    }
}