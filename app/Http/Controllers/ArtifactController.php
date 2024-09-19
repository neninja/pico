<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArtifactRequest;
use App\Http\Requests\UpdateArtifactRequest;
use App\Models\Artifact;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ArtifactController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Artifact::class, 'artifact');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $artifacts = QueryBuilder::for(Artifact::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
            ])
            ->allowedSorts('created_at')
            ->paginate(request()->query('limit', self::DEFAULT_PAGINATION_LIMIT));

        return response()->json($artifacts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArtifactRequest $request): JsonResponse
    {
        $artifact = Artifact::create([
            'catalog_id' => $request->input('catalog_id'),
            'title' => $request->input('title'),
            'order' => $request->input('order'),
        ]);

        return response()->json($artifact);
    }

    /**
     * Display the specified resource.
     */
    public function show(Artifact $artifact): JsonResponse
    {
        return response()->json($artifact);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArtifactRequest $request, Artifact $artifact): JsonResponse
    {
        $artifact->update($request->validated());

        return response()->json($artifact);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artifact $artifact)
    {
        $artifact->delete();

        return response()->json($artifact);
    }
}
