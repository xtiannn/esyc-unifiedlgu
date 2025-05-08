<?php
// app\Http\Controllers\BannerController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner; // Replace with your actual model
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'banner_image' => 'required|image|max:2048', // Validate the image
        ]);

        // Delete the existing banner
        $existingBanner = Banner::first();
        if ($existingBanner) {
            // Remove the old file if it exists
            if (Storage::disk('public')->exists($existingBanner->image_path)) {
                Storage::disk('public')->delete($existingBanner->image_path);
            }

            // Delete the database record
            $existingBanner->delete();
        }

        // Handle new file upload
        $path = $request->file('banner_image')->store('banners', 'public');

        // Save new banner record
        Banner::create([
            'image_path' => $path,
        ]);

        return redirect()->back()->with('success', 'Banner uploaded successfully.');
    }
    public function fetchBanner()
    {
        $banner = Banner::latest()->first(); // Assuming you fetch the latest banner
        return response()->json([
            'image_path' => $banner->image_path ?? null
        ]);
    }
}
