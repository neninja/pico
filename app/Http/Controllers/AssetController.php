<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Models\Asset;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AssetController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Asset::class, 'asset');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $asset = QueryBuilder::for(Asset::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
            ])
            ->allowedSorts('created_at')
            ->paginate(request()->query('limit', self::DEFAULT_PAGINATION_LIMIT));

        return response()->json($asset);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssetRequest $request)
    {
        $asset = Asset::create([
            'paid_amount' => $request->input('paid_amount'),
            'artifact_id' => $request->input('artifact_id'),
            'user_id' => auth()->user()->id,
        ]);

        return response()->json($asset);
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        return response()->json($asset);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssetRequest $request, Asset $asset)
    {
        $asset->update($request->validated());

        return response()->json($asset);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();

        return response()->json($asset);
    }
}
