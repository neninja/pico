<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCatalogRequest;
use App\Http\Requests\UpdateCatalogRequest;
use App\Models\Catalog;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CatalogController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Catalog::class, 'catalog');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $catalogs = QueryBuilder::for(Catalog::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
            ])
            ->allowedSorts('created_at')
            ->paginate(request()->query('limit', self::DEFAULT_PAGINATION_LIMIT));

        return response()->json($catalogs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCatalogRequest $request): JsonResponse
    {
        $catalog = Catalog::create([
            'title' => $request->input('title'),
            'artifact_label' => $request->input('artifact_label'),
            'artifact_plural_label' => $request->input('artifact_plural_label'),
        ]);

        return response()->json($catalog);
    }

    /**
     * Display the specified resource.
     */
    public function show(Catalog $catalog): JsonResponse
    {
        return response()->json($catalog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCatalogRequest $request, Catalog $catalog): JsonResponse
    {
        $catalog->update($request->validated());

        return response()->json($catalog);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Catalog $catalog): JsonResponse
    {
        $catalog->delete();

        return response()->json($catalog);
    }
}
