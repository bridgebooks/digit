<?php

namespace App\Http\Controllers\V1\PayItems;

use App\Http\Controllers\V1\Controller;
use App\Http\Requests\V1\CreatePayItem;
use App\Http\Requests\V1\UpdatePayItem;
use App\Repositories\PayItemRepository;
use App\Traits\UserRequest;

class PayitemController extends Controller
{
    use UserRequest;

    protected $repository;

    public function __construct(PayItemRepository $repository)
    {
        $this->middleware('jwt.auth');
        $this->middleware('acl:payroll')->only(['create', 'read', 'update', 'delete']);
        $this->repository = $repository;
    }

    /**
     * @param CreatePayItem $request
     * @return mixed
     */
    public function create(CreatePayItem $request)
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
       return $this->repository->find($id);
   }

    /**
     * @param UpdatePayItem $request
     * @param string $id
     * @return mixed
     */
    public function update(UpdatePayItem $request, string $id)
   {
       $item = $this->repository->skipPresenter()->find($id);

       $this->authorize('update', $item);

       $attrs = $request->all();

       return $this->repository->update($attrs, $id);
   }

    /**
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function archive(string $id)
   {
       $item = $this->repository->skipPresenter()->find($id);

       $this->authorize('archive', $item);

       $this->repository->delete($id);

       return response()->json([
           'status' => 'success',
           'message' => 'Item successfully archived'
       ]);
   }

    /**
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(string $id)
    {
        $item = \App\Models\PayItem::onlyTrashed()->find($id);

        $this->authorize('delete', $item);

        $this->repository->forceDelete($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Item successfully deleted'
        ]);
    }

    /**
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(string $id)
    {
        $item = \App\Models\PayItem::onlyTrashed()->find($id);

        $this->authorize('archive', $item);

        $item->restore();

        return response()->json([
            'status' => 'success',
            'message' => 'Item successfully restored'
        ]);
    }
}