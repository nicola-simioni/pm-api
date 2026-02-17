<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization;

class OrganizationController extends Controller
{
    /**
     * Display a listing of organizations.
     *
     * GET /api/organizations
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $organizations = Organization::with('users', 'projects')->get();
        return response()->json($organizations);
    }

    /**
     * Store a newly created organization in storage.
     *
     * POST /api/organizations
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $organization = Organization::create($request->only('name', 'description'));

        return response()->json($organization, 201);
    }

    /**
     * Display the specified organization.
     *
     * GET /api/organizations/{id}
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $organization = Organization::with('users', 'projects')->findOrFail($id);
        return response()->json($organization);
    }

    /**
     * Update the specified organization in storage.
     *
     * PUT /api/organizations/{id}
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $organization = Organization::findOrFail($id);
        $organization->update($request->only('name', 'description'));

        return response()->json($organization);
    }

    /**
     * Remove the specified organization from storage.
     *
     * DELETE /api/organizations/{id}
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        $organization = Organization::findOrFail($id);
        $organization->delete();

        return response()->json(['message' => 'Organization deleted successfully.']);
    }
}
