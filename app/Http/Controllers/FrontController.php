<?php

namespace App\Http\Controllers;

use App\Models\CarService;
use App\Models\CarStore;
use App\Models\City;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $cities = City::all();

        $services = CarService::withCount(['storeServices'])->get();
        return view('pages.home', compact('cities', 'services'));
    }

    public function search(Request $request)
    {
        $cityId = $request->input('city_id');
        $serviceType = $request->input('service_type');


        $carService = CarService::where('id', $serviceType)->first();
        if (!$carService) {
            return redirect()->back()->with('error', 'Data service tidak di temukan');
        }

        $stores = CarStore::whereHas('storeServices', function ($query) use ($carService) {
            $query->where('car_service_id', $carService->id);
        })->where('city_id', $cityId)->get();

        $city = City::find($cityId);

        return view('pages.store', [
            'stores' => $stores,
            'carService' => $carService,
            'cityName' => $city ? $city->name : 'City tidak ditemukan'
        ]);
    }

    public function detail(CarStore $carStore)
    {
        return view('pages.detail', compact('carStore'));
    }
}
