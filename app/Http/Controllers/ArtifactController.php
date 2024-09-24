<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArtifactRequest;
use App\Http\Requests\UpdateArtifactRequest;
use App\Http\Resources\ArtifactResource;
use App\Models\Artifact;
use Illuminate\Http\Resources\Json\JsonResource;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

#[Group('Artifact', 'Gerenciamento de artefatos colecionáveis')]
class ArtifactController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Artifact::class, 'artifact');
    }

    /**
     * Display a listing of the resource.
     */
    #[ResponseFromApiResource(ArtifactResource::class, Artifact::class)]
    public function index(): JsonResource
    {
        $artifacts = QueryBuilder::for(Artifact::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
            ])
            ->allowedSorts('created_at')
            ->paginate(request()->query('limit', self::DEFAULT_PAGINATION_LIMIT));

        return ArtifactResource::collection($artifacts);
    }

    /**
     * Store a newly created resource in storage.
     */
    #[ResponseFromApiResource(ArtifactResource::class, Artifact::class)]
    public function store(StoreArtifactRequest $request): JsonResource
    {
        $artifact = Artifact::create([
            'catalog_id' => $request->input('catalog_id'),
            'title' => $request->input('title'),
            'order' => $request->input('order'),
        ]);

        return new ArtifactResource($artifact);
    }

    /**
     * Display the specified resource.
     */
    #[ResponseFromApiResource(ArtifactResource::class, Artifact::class)]
    public function show(Artifact $artifact): JsonResource
    {
        return new ArtifactResource($artifact);
    }

    /**
     * Update the specified resource in storage.
     */
    #[ResponseFromApiResource(ArtifactResource::class, Artifact::class)]
    public function update(UpdateArtifactRequest $request, Artifact $artifact): JsonResource
    {
        $artifact->update($request->validated());

        return new ArtifactResource($artifact);
    }

    /**
     * Remove the specified resource from storage.
     */
    #[ResponseFromApiResource(ArtifactResource::class, Artifact::class)]
    public function destroy(Artifact $artifact)
    {
        $artifact->delete();

        return new ArtifactResource($artifact);
    }
}
