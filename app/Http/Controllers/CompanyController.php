<?php

namespace App\Http\Controllers;

use App\Http\Resources\CompanyResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    use CanLoadRelationships;

    private array $relations = ['comments'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $name = $request->input('name');
        $sort = $request->input('sort');

        $query = $this->loadRelationships(
            Company::when($name, fn($q) => $q->name($name)),
            $this->relations
        );
        $query->withMostRecentComment();

        if ($sort) {
            $sort = str_replace([',', '|'], ['&', '='], $sort);
            parse_str($sort, $sort);

            foreach ($sort as $sortBy => $sortOrder) {
                match ($sortBy) {
                    'company_name' => $query->orderBy('name', $sortOrder),
                    'comments_time' => $query->orderBy('comments_max_updated_at', $sortOrder),
                    'average_comments_rating' => $query->orderBy('comments_avg_rating', $sortOrder),
                    default => null
                };
            }
        }

        return new CompanyResource(
            $query->withAvg('comments', 'rating')->paginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return new CompanyResource(
            $this->loadRelationships($company, $this->relations)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
