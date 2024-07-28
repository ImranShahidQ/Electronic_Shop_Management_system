<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Claim;
use App\Models\Product;

class ClaimController extends Controller
{
    public function index()
    {
        $claims = Claim::with('product')->get();
        $totalClaimsQuantity = $claims->sum('quantity');
        return view('claims.index', compact('claims', 'totalClaimsQuantity'));
    }

    public function create()
    {
        $products = Product::all();
        return view('claims.create', compact('products'));
    }

    public function store(Request $request)
    {
        $claim = new Claim();
        $claim->product_id = $request->product_id;
        $claim->type = $request->type;
        $claim->quantity = $request->quantity;
        $claim->date = $request->date;
        $claim->save();

        $product = Product::find($request->product_id);
        if ($request->type == 'returned') {
            $product->stock -= $request->quantity;
        } else {
            $product->stock += $request->quantity;
        }
        $product->save();

        return redirect()->route('claims.index');
    }
}
