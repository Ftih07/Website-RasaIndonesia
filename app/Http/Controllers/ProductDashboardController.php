<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductOptionGroup;
use App\Models\ProductOption;
use App\Models\ProductCategory;
use App\Models\Business;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $business = $user->business;

        $products = $business->products()->with(['optionGroups.options', 'categories'])->get();
        $optionGroups = $business->productOptionGroups()->with('options')->get();
        $categories = $business->categories;

        return view('dashboard.product', compact('products', 'optionGroups', 'categories'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $business = $user->business;

        $validated = $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image',
            'price' => 'required|numeric',
            'serving' => 'nullable|string',
            'desc' => 'nullable|string',
            'max_distance' => 'nullable|numeric|min:1',
            'option_groups' => 'array',
            'categories' => 'array',
        ]);

        $product = new Product($validated);
        $product->business_id = $business->id;

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('product-images', 'public');
        }

        $product->save();

        if ($request->has('option_groups')) {
            $product->optionGroups()->sync($request->option_groups);
        }

        if ($request->has('categories')) {
            $product->categories()->sync($request->categories);
        }

        return redirect()->route('dashboard.product')->with('success', 'Product created.');
    }

    public function edit($id)
    {
        $user = auth()->user();
        $business = $user->business;

        $product = Product::with(['optionGroups', 'categories'])->findOrFail($id);

        // Pastikan milik bisnis user
        if ($product->business_id !== $business->id) {
            abort(403);
        }

        $optionGroups = $business->productOptionGroups;
        $categories = $business->categories;

        return view('dashboard.product-edit', compact('product', 'optionGroups', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $product = Product::findOrFail($id);

        if ($product->business_id !== $user->business->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image',
            'price' => 'required|numeric',
            'serving' => 'nullable|string',
            'desc' => 'nullable|string',
            'max_distance' => 'nullable|numeric|min:1',
            'option_groups' => 'array',
            'categories' => 'array',
        ]);

        $product->fill($validated);

        if ($request->hasFile('image')) {
            // Hapus lama jika ada
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->image = $request->file('image')->store('product-images', 'public');
        }

        $product->save();

        $product->optionGroups()->sync($request->option_groups ?? []);
        $product->categories()->sync($request->categories ?? []);

        return redirect()->route('dashboard.product')->with('success', 'Product updated successfully.');
    }


    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Optional: pastikan hanya produk milik user tersebut
        if ($product->business_id !== Auth::user()->business->id) {
            abort(403);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return back()->with('success', 'Product deleted.');
    }

    // PRODUCT OPTION GROUP
    public function storeOptionGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $group = new ProductOptionGroup([
            'name' => $request->name,
            'is_required' => $request->has('is_required'),
            'max_selection' => $request->max_selection,
            'business_id' => auth()->user()->business->id,
        ]);
        $group->save();

        if ($request->has('options')) {
            foreach ($request->options as $opt) {
                $group->options()->create([
                    'name' => $opt['name'],
                    'price' => $opt['price'] ?? 0,
                ]);
            }
        }

        return back()->with('success', 'Option group created.');
    }

    public function destroyOptionGroup($id)
    {
        $group = ProductOptionGroup::findOrFail($id);
        $group->delete();
        return back()->with('success', 'Option group deleted.');
    }

    public function updateOptionGroup(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'options' => 'array',
            'options.*.name' => 'required|string',
            'options.*.price' => 'nullable|numeric',
        ]);

        $business = auth()->user()->business;
        $group = $business->optionGroups()->where('id', $id)->firstOrFail();

        $group->update([
            'name' => $request->name,
            'is_required' => $request->has('is_required'),
            'max_selection' => $request->max_selection,
        ]);

        // Ambil semua option ID yang dikirim
        $submittedOptionIds = collect($request->options)->pluck('id')->filter()->all();

        // Hapus option yang tidak ada di form (berarti dihapus user)
        $group->options()->whereNotIn('id', $submittedOptionIds)->delete();

        // Simpan atau update option yang dikirim
        foreach ($request->options as $option) {
            if (!empty($option['id'])) {
                // Update option yang sudah ada
                $group->options()->where('id', $option['id'])->update([
                    'name' => $option['name'],
                    'price' => $option['price'] ?? 0,
                ]);
            } else {
                // Buat option baru
                $group->options()->create([
                    'name' => $option['name'],
                    'price' => $option['price'] ?? 0,
                ]);
            }
        }

        return redirect()->to(route('dashboard.product') . '#option-groups')
            ->with('success', 'Option group updated.');
    }

    // CATEGORIES
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        auth()->user()->business->categories()->create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Category created.');
    }

    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);

        // Tambahkan pengecekan supaya hanya bisa edit category milik bisnis user
        if ($category->business_id !== auth()->user()->business->id) {
            abort(403);
        }

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('dashboard.product')->with('success', 'Category updated.');
    }
}
