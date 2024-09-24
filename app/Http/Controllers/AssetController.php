<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Http\Resources\AssetResource;
use App\Models\Asset;
use Illuminate\Http\Resources\Json\JsonResource;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

#[Group('Asset', 'Gerenciamento de unidades colecionaveis do usuário')]
class AssetController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Asset::class, 'asset');
    }

    /**
     * Display a listing of the resource.
     */
    #[ResponseFromApiResource(AssetResource::class, Asset::class)]
    public function index(): JsonResource
    {
        $asset = QueryBuilder::for(Asset::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
            ])
            ->allowedSorts('created_at')
            ->paginate(request()->query('limit', self::DEFAULT_PAGINATION_LIMIT));

        return AssetResource::collection($asset);
    }

    /**
     * Store a newly created resource in storage.
     */
    #[ResponseFromApiResource(AssetResource::class, Asset::class)]
    public function store(StoreAssetRequest $request): JsonResource
    {
        $asset = Asset::create([
            'paid_amount' => $request->input('paid_amount'),
            'artifact_id' => $request->input('artifact_id'),
            'user_id' => auth()->user()->id,
        ]);

        return new AssetResource($asset);
    }

    /**
     * Display the specified resource.
     */
    #[ResponseFromApiResource(AssetResource::class, Asset::class)]
    public function show(Asset $asset): JsonResource
    {
        return new AssetResource($asset);
    }

    /**
     * Update the specified resource in storage.
     */
    #[ResponseFromApiResource(AssetResource::class, Asset::class)]
    public function update(UpdateAssetRequest $request, Asset $asset): JsonResource
    {
        $asset->update($request->validated());

        return new AssetResource($asset);
    }

    /**
     * Remove the specified resource from storage.
     */
    #[ResponseFromApiResource(AssetResource::class, Asset::class)]
    public function destroy(Asset $asset): JsonResource
    {
        $asset->delete();

        return new AssetResource($asset);
    }
}
