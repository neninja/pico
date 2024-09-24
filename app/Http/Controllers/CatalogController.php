<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCatalogRequest;
use App\Http\Requests\UpdateCatalogRequest;
use App\Http\Resources\CatalogResource;
use App\Models\Catalog;
use Illuminate\Http\Resources\Json\JsonResource;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

#[Group('Catalog', 'Gerenciamento de coleções de artefatos')]
class CatalogController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Catalog::class, 'catalog');
    }

    /**
     * Display a listing of the resource.
     */
    #[ResponseFromApiResource(CatalogResource::class, Catalog::class)]
    public function index(): JsonResource
    {
        $catalogs = QueryBuilder::for(Catalog::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
            ])
            ->allowedSorts('created_at')
            ->paginate(request()->query('limit', self::DEFAULT_PAGINATION_LIMIT));

        return CatalogResource::collection($catalogs);
    }

    /**
     * Store a newly created resource in storage.
     */
    #[ResponseFromApiResource(CatalogResource::class, Catalog::class)]
    public function store(StoreCatalogRequest $request): JsonResource
    {
        $catalog = Catalog::create([
            'title' => $request->input('title'),
            'artifact_label' => $request->input('artifact_label'),
            'artifact_plural_label' => $request->input('artifact_plural_label'),
        ]);

        return new CatalogResource($catalog);
    }

    /**
     * Display the specified resource.
     */
    #[ResponseFromApiResource(CatalogResource::class, Catalog::class)]
    public function show(Catalog $catalog): JsonResource
    {
        return new CatalogResource($catalog);
    }

    /**
     * Update the specified resource in storage.
     */
    #[ResponseFromApiResource(CatalogResource::class, Catalog::class)]
    public function update(UpdateCatalogRequest $request, Catalog $catalog): JsonResource
    {
        $catalog->update($request->validated());

        return new CatalogResource($catalog);
    }

    /**
     * Remove the specified resource from storage.
     */
    #[ResponseFromApiResource(CatalogResource::class, Catalog::class)]
    public function destroy(Catalog $catalog): JsonResource
    {
        $catalog->delete();

        return new CatalogResource($catalog);
    }
}
