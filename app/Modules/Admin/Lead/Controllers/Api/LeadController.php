<?php

namespace App\Modules\Admin\Lead\Controllers\Api;

use App\Modules\Admin\Lead\Models\Lead;
use App\Modules\Admin\Lead\Request\LeadCreateRequest;
use App\Modules\Admin\Lead\Services\LeadService;
use App\Modules\Admin\Status\Models\Status;
use App\Services\Response\ResponseService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{

    private $service;

    public function __construct(LeadService $service) {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $this->authorize('view', Lead::class);
        return ResponseService::sendJsonResponse(true, 200,[],[
            'items' =>  $this->service->getLeads()
        ]);
    }

    /**
     * Create of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LeadCreateRequest $request) {
        $this->authorize('create', Lead::class);
        $lead = $this->service->store($request, Auth::user());
        return ResponseService::sendJsonResponse(true, 200, [],[
            'item' => $lead->renderData()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modules\Admin\Lead\Models\Lead  $lead
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Lead $lead) {
        $this->authorize('view', Lead::class);
        return ResponseService::sendJsonResponse(true, 200,[],[
            'item' =>  $lead
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modules\Admin\Lead\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function edit(Lead $lead) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modules\Admin\Lead\Models\Lead  $lead
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(LeadCreateRequest $request, Lead $lead) {
        $this->authorize('edit', Lead::class);
        $lead = $this->service->update($request, Auth::user(), $lead);
        return ResponseService::sendJsonResponse(true, 200, [],[
            'item' => $lead->renderData()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modules\Admin\Lead\Models\Lead  $lead
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lead $lead)
    {
        //
    }

    public function archive() {
        $this->authorize('view', Lead::class);
        $leads = $this->service->archive();
        return ResponseService::sendJsonResponse(true, 200, [],[
            'items' => $leads
        ]);
    }

    public function checkExist(Request $request) {
        $this->authorize('create', Lead::class);
        $lead = $this->service->checkExist($request);
        if($lead) {
            return ResponseService::sendJsonResponse(true, 200, [],[
                'item' => $lead,
                'exist' => true
            ]);
        }
        return ResponseService::success();
    }

    public function updateQuality(Request $request, Lead $lead) {
        $this->authorize('edit', Lead::class);
        $lead = $this->service->updateQuality($request, $lead);
        return ResponseService::sendJsonResponse(true, 200, [],[
            'item' => $lead->renderData()
        ]);
    }

    public function getAddSaleCount() {
        $count = $this->service->getAddSaleCount();
        return ResponseService::sendJsonResponse(true, 200, [],[
            'number' => $count
        ]);

    }

    public function comments(Lead $lead) {
        $this->authorize('view', Lead::class);
        return ResponseService::sendJsonResponse(true, 200, [],[
            'items' => $lead->comments->transform(function ($item) {
                $item->load('status', 'user');
                $item->created_at_r = $item->created_at->toDateTimeString();
                return $item;
            })->toArray()
        ]);
    }
}
