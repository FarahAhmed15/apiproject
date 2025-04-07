<?php

namespace App\Http\Controllers\Service;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(){
        $services=Category::all();
        if($services !== null){
            return CategoryResource::collection($services);
        }else{
            return response()->json([
                "msg"=>"data not found"
            ],404);
        }
    }
    public function show($id){
        $category=Category::with('services:id,service_type,category_id')->select(['id','category_name'])->findorfail($id);
        if($category !== null){
            return response()->json($category);
        }else{
            return response()->json([
                "msg"=>"data not found"
            ],404);
        }
    }
    public function getProvidersByService($id)
    {
        $service = Service::findOrFail($id);
        
        $providers = $service->serviceproviders()
            ->with(['category:id,category_name'])
            ->select(['service_providers.id', 'service_providers.name', 'service_providers.experience_years','service_providers.category_id'])
            ->get()
            ->map(function ($provider) {
                $provider->price = $provider->pivot->price;
                unset($provider->pivot);
                return $provider;
            });
        
        return response()->json([
            'status' => true,
            'service' => [
                'id' => $service->id,
                'name' => $service->service_type,
            ],
            'providers' => $providers
        ]);
    }

}
