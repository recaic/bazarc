<?php

namespace App\Repositories\Eloquent;

use App\Presenters\ActivityLogPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Repositories\ActivityLogRepository;
use App\Models\ActivityLog;

/**
 * Class UserActivityRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ActivityLogRepositoryEloquent extends BaseRepository implements ActivityLogRepository
{
    /**
     * @var bool
     */
    protected $skipPresenter = true;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ActivityLog::class;
    }

    /**
     * @return string
     */
    public function presenter()
    {
        return ActivityLogPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
