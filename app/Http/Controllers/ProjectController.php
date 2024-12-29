<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Projects;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function getProjects()
    {
        try {
            $projects = Projects::with('user')->get();

            return response()->json([
                'status' => 1,
                'message' => 'Projects retrieved successfully',
                'data' => $projects],
                200);
        } catch (Exception $e) {
            Log::error('Error on get projects'.$e->getMessage().' on line '.$e->getLine().' in file '.$e->getFile());

            return response()->json([
                'status' => 0,
                'message' => 'Failed to retrieve projects'],
                500);
        }
    }

    public function createProject(ProjectRequest $request)
    {
        try {
            $user = $request->user();
            // Generate unique project key
            $project = Projects::create([
                'name' => Str::ucfirst($request->name),
                'key' => Str::upper($request->key),
                'image' => $request->image,
                'created_by' => $user->id,
            ]);

            return response()->json([
                'status' => 1,
                'message' => 'Project created successfully',
                'data' => $project],
                200);
        } catch (Exception $e) {
            Log::error('Error on create project'.$e->getMessage().' on line '.$e->getLine().' in file '.$e->getFile());

            return response()->json([
                'status' => 0,
                'message' => 'Failed to create project'],
                500);
        }
    }

    public function updateProject($projectId, ProjectRequest $request)
    {
        
        try {
            $project = Projects::find($projectId);
            if (! $project) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Project not found'],
                    404);
            }
            $project->update([
                'name' => Str::ucfirst($request->name),
                'key' => Str::upper($request->key),
                'image' => $request->image,
            ]);

            return response()->json([
                'status' => 1,
                'message' => 'Project updated successfully',
                'data' => $project,
            ],
                200);

        } catch (Exception $e) {
            Log::error('Error on update project'.$e->getMessage().' on line '.$e->getLine().' in file '.$e->getFile());

            return response()->json([
                'status' => 0,
                'message' => 'Failed to delete project'],
                500);
        }
    }

    public function deleteProject($projectId)
    {
        try {

            $project = Projects::find($projectId);
            if (! $project) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Project not found'],
                    404);
            }
            $project->delete();

            return response()->json([
                'status' => 1,
                'message' => 'Project deleted successfully'],
                200);
        } catch (Exception $e) {
            Log::error('Error on delete project'.$e->getMessage().' on line '.$e->getLine().' in file '.$e->getFile());

            return response()->json([
                'status' => 0,
                'message' => 'Failed to delete project'],
                500);
        }
    }
}
