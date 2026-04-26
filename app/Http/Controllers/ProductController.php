<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'user'])->get();

        return view('product.index', compact('products'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $validated['qty'] = $validated['quantity'];
        unset($validated['quantity']);

        try {
            Product::create($validated);

            return redirect()
                ->route('product.index')
                ->with('success', 'Product created successfully.');

        } catch (QueryException $e) {
            Log::error('Product store database error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Database error while creating product.');
        } catch (\Throwable $e) {
            Log::error('Product store unexpected error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Unexpected error occurred.');
        }
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('product.create', compact('users', 'categories'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return view('product.view', compact('product'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        Gate::authorize('update', $product);

        $validated = $request->validated();

        if (array_key_exists('quantity', $validated)) {
            $validated['qty'] = $validated['quantity'];
            unset($validated['quantity']);
        }

        try {
            $product->update($validated);

            return redirect()
                ->route('product.index')
                ->with('success', 'Product updated successfully.');

        } catch (QueryException $e) {
            Log::error('Product update database error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Database error while updating product.');
        } catch (\Throwable $e) {
            Log::error('Product update unexpected error', [
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Unexpected error occurred.');
        }
    }

    public function edit(Product $product)
    {
        Gate::authorize('update', $product);

        $users = User::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        return view('product.edit', compact('product', 'users', 'categories'));
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        Gate::authorize('delete', $product);

        $product->delete();

        return redirect()->route('product.index')->with('success','Product berhasil dihapus');
    }

    public function export()
    {
        $products = Product::with(['category', 'user'])->get();

        $filename = 'products_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($products) {
            $handle = fopen('php://output', 'w');

            // BOM for Excel UTF-8 compatibility
            fputs($handle, "\xEF\xBB\xBF");

            // Header row
            fputcsv($handle, ['No', 'Nama Produk', 'Kategori', 'Qty', 'Harga', 'Owner']);

            foreach ($products as $index => $product) {
                fputcsv($handle, [
                    $index + 1,
                    $product->name,
                    $product->category->name ?? '-',
                    $product->qty,
                    $product->price,
                    $product->user->name ?? '-',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
