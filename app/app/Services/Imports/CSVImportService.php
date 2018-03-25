<?php

namespace App\Services\Imports;

use App\Models\User;
use League\Csv\Exception;
use Storage;
use League\Csv\Reader;
use Prettus\Repository\Contracts\RepositoryInterface;

class CSVImportService
{
    protected $repository;
    protected $name;
    protected $user;
    protected $org_id;

    public function __construct(string $name, RepositoryInterface $repository, User $user)
    {
        $this->name = $name;
        $this->repository = $repository;
        $this->user = $user;
    }

    /**
     * @param $records
     */
    private function addToRepository($records)
    {
        $models = [];
        foreach($records as $offset => $record)
        {
            $extras = [
                'user_id' => $this->user->id,
                'org_id' => $this->org_id
            ];
            $model = array_merge($record, $extras);
            $this->repository->create($model);
        }
    }

    public function setOrgID(string $id)
    {
        $this->org_id = $id;
        return $this;
    }

    /**
     * @throws \League\Csv\Exception
     */
    public function process()
    {
        $path = 'tmp/imports/'.$this->name;
        $contents = Storage::get($path);

        $csv = Reader::createFromString($contents);
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        if ($records) {
            foreach($records as $offset => $record)
            {
                $extras = [
                    'user_id' => $this->user->id,
                    'org_id' => $this->org_id
                ];
                $model = array_merge($record, $extras);

                $this->repository->create($model);
            }

            return true;
        } else {
            return false;
        }
    }
}