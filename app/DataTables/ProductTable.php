<?php

namespace App\DataTables;

use App\DataTables\Table;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductTable extends Table
{
    /**
     * Get query source of dataTable.
     *
     */
    public function query(Request $request)
    {
        $model = Product::where('tbl_product.product_status', 'active')
                            ->where(function ($query) use ($request) {
                                if ($request->select_product != 'all') {
                                    $query->where('tbl_product.name', $request->select_product);
                                } else {
                                    $query;
                                }
                            })
                            ->whereBetween('tbl_sales_invoice.invoice_date', [$request->start_date, $request->end_date])

                            ->leftJoin('tbl_sales_invoice_item', 'tbl_product.id', '=', 'tbl_sales_invoice_item.product_id')
                            ->leftJoin('tbl_sales_invoice', 'tbl_sales_invoice_item.invoice_id', '=', 'tbl_sales_invoice.id')
                            ->leftJoin('tbl_customer', 'tbl_sales_invoice.customer_id', '=', 'tbl_customer.id')
                            ->leftJoin('tbl_packaging', 'tbl_sales_invoice_item.packaging_id', '=', 'tbl_packaging.id')
                            ->selectRaw('
                                tbl_sales_invoice.id as invoiceID, 
                                tbl_sales_invoice.invoice_code as nota, 
                                tbl_product.product_name as product, 
                                tbl_packaging.packaging_name as packaging, 
                                tbl_customer.customer_store_name as customer, 
                                tbl_sales_invoice_item.invoice_item_qty as qty, 
                            ');

        return $model;
    }

    /**
     * Build DataTable class.
     */
    public function build(Request $request)
    {
        $table = Table::of($this->query($request));

        return $table->make(true);
    }
}