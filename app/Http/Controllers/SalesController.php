<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;

class SalesController extends Controller
{
    public function index()
    {
        // Agregar vendas por produto
        $salesByProduct = Sale::selectRaw('product_name, SUM(quantity_sold) as total_quantity,
SUM(total_amount) as total_sales')
            ->groupBy('product_name')
            ->get();

        // Agregar vendas por mês
        $salesByMonth = Sale::selectRaw('MONTH(sale_date) as month, SUM(total_amount) as
total_sales')
            ->groupBy('month')
            ->get();
        // Agregar vendas por ano
        $salesByYear = Sale::selectRaw('YEAR(sale_date) as year, SUM(total_amount) as total_sales')
            ->groupBy('year')
            ->get();
        // Passar os dados para a view
        return view('dashboard', compact('salesByProduct', 'salesByMonth', 'salesByYear'));
    }

}
