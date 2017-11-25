<?php

namespace App\Http\Controllers\V1\Employees;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\BulkDeleteEmployees;
use App\Http\Requests\V1\BulkEmployeeAction;
use App\Http\Requests\V1\CreateEmployee;
use App\Http\Requests\V1\UpdateEmployee;
use App\Repositories\EmployeeRepository;
use App\Traits\UserRequest;

class EmployeeController extends Controller
{
    use UserRequest;

    protected $repository;

    /**
     * EmployeeController constructor.
     * @param EmployeeRepository $repository
     */
    public function __construct(EmployeeRepository $repository)
    {
        $this->middleware('jwt.auth');
        $this->middleware('acl:employees.view')->only(['read']);
        $this->middleware('acl:employees.create')->only(['create']);
        $this->middleware('acl:employees.edit')->only(['update']);
        $this->middleware('acl:employees.delete')->only(['delete']);
        $this->middleware('acl:payroll')->only(['bulkDelete', 'bulkArchive', 'bulkRestore', 'bulkTerminate']);

        $this->repository = $repository;
    }

    /**
     * @param CreateEmployee $request
     * @return mixed
     */
    public function create(CreateEmployee $request)
    {
        $attrs = $request->all();

        $attrs['user_id'] = $this->requestUser()->id;

        return $this->repository->create($attrs);
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function read(string $id)
    {
        $employee = \App\Models\Employee::find($id);

        $this->authorize('view', $employee);

        return $this->repository->find($id);
    }

    /**
     * @param UpdateEmployee $request
     * @param string $id
     * @return mixed
     */
    public function update(UpdateEmployee $request, string $id)
    {
        $attrs = $request->all();

        $employee = \App\Models\Employee::find($id);

        $this->authorize('update', $employee);

        return $this->repository->update($attrs, $id);
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(string $id)
    {
        $employee = \App\Models\Employee::find($id);

        $this->authorize('delete', $employee);

        $employee->forceDelete();

        return response()->json([
            'status' => 'success',
            'message' => 'Employee archived successfully'
        ]);
    }

    /**
     * @param BulkEmployeeAction $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkDelete(BulkEmployeeAction $request)
    {
        $ids = $request->get('employees');

        $this->repository->deleteMany($ids);

        return response()->json([
            'status' => 'success',
            'message' => 'Models successfully deleted'
        ]);
    }

    /**
     * @param BulkEmployeeAction $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkArchive(BulkEmployeeAction $request)
    {
        $ids = $request->get('employees');

        $this->repository->archiveMany($ids);

        return response()->json([
            'status' => 'success',
            'message' => 'Models successfully deleted'
        ]);
    }

    /**
     * @param BulkEmployeeAction $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkRestore(BulkEmployeeAction $request)
    {
        $ids = $request->get('employees');

        $this->repository->restoreMany($ids);

        return response()->json([
            'status' => 'success',
            'message' => 'Models successfully restored'
        ]);
    }

    /**
     * @param BulkEmployeeAction $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function bulkTerminate(BulkEmployeeAction $request)
    {
        $ids = $request->get('employees');

        $this->repository->terminateMany($ids);

        return response()->json([
            'status' => 'success',
            'message' => 'Models successfully restored'
        ]);
    }
}