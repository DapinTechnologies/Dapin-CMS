<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\IncomeCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class IncomeReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->title = 'Income Report';
        $this->route = 'admin.income-report';
        $this->view = 'admin.income-report';
        $this->access = 'income-report';

        $this->middleware('permission:'.$this->access.'-view', ['only' => ['index','show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;

        // Filter parameters
        $data['selected_category'] = $request->category ?? 'all';
        $data['selected_payment_method'] = $request->payment_method ?? 'all';
        $data['selected_start_date'] = $request->start_date ?? date('Y-m-01');
        $data['selected_end_date'] = $request->end_date ?? date('Y-m-t');
        $data['selected_group_by'] = $request->group_by ?? 'day';
        $data['selected_chart_type'] = $request->chart_type ?? 'line';

        // Get categories for filter
        $data['categories'] = IncomeCategory::where('status', '1')
                            ->orderBy('title', 'asc')->get();

        // Get income data with filters
        $query = Income::with('category')
            ->whereBetween('date', [$data['selected_start_date'], $data['selected_end_date']]);

        if ($data['selected_category'] != 'all') {
            $query->where('category_id', $data['selected_category']);
        }

        if ($data['selected_payment_method'] != 'all') {
            $query->where('payment_method', $data['selected_payment_method']);
        }

        $data['incomes'] = $query->orderBy('date', 'desc')->get();
        $data['total_income'] = $data['incomes']->sum('amount');

        // Get chart data
        $data['chart_data'] = $this->getChartData($query, $data['selected_group_by']);

        return view($this->view.'.index', $data);
    }

    /**
     * Get chart data for visualization
     */
    private function getChartData($query, $groupBy)
    {
        $incomes = $query->get();
        
        if ($groupBy == 'day') {
            $data = $incomes->groupBy(function($item) {
                return Carbon::parse($item->date)->format('Y-m-d');
            })->map(function($group) {
                return $group->sum('amount');
            });
        } elseif ($groupBy == 'week') {
            $data = $incomes->groupBy(function($item) {
                return Carbon::parse($item->date)->format('Y-W');
            })->map(function($group) {
                return $group->sum('amount');
            });
        } elseif ($groupBy == 'month') {
            $data = $incomes->groupBy(function($item) {
                return Carbon::parse($item->date)->format('Y-m');
            })->map(function($group) {
                return $group->sum('amount');
            });
        } else { // category
            $data = $incomes->groupBy('category_id')->map(function($group) {
                return $group->sum('amount');
            });
            
            // Get category names
            $categoryData = [];
            foreach ($data as $categoryId => $amount) {
                $category = IncomeCategory::find($categoryId);
                $categoryData[$category ? $category->title : 'Unknown'] = $amount;
            }
            return $categoryData;
        }

        return $data;
    }

    /**
     * Get chart data via AJAX
     */
    public function chartData(Request $request)
    {
        $query = Income::with('category')
            ->whereBetween('date', [$request->start_date, $request->end_date]);

        if ($request->category != 'all') {
            $query->where('category_id', $request->category);
        }

        if ($request->payment_method != 'all') {
            $query->where('payment_method', $request->payment_method);
        }

        $chartData = $this->getChartData($query, $request->group_by);

        return response()->json([
            'labels' => array_keys($chartData->toArray()),
            'data' => array_values($chartData->toArray()),
            'total' => array_sum($chartData->toArray())
        ]);
    }

    /**
     * Print report
     */
    public function print(Request $request)
    {
        $data = $this->getReportData($request);
        return view($this->view.'.print', $data);
    }

    /**
     * Generate PDF report
     */
    public function pdf(Request $request)
    {
        $data = $this->getReportData($request);
        
        $pdf = PDF::loadView($this->view.'.pdf', $data)
            ->setPaper('a4', 'landscape')
            ->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        
        return $pdf->download('income-report-'.date('Y-m-d').'.pdf');
    }

    /**
     * Get common report data
     */
    private function getReportData($request)
    {
        $data['title'] = 'Income Report';
        $data['print_date'] = now()->format('Y-m-d H:i:s');

        // Filter parameters
        $category = $request->category ?? 'all';
        $payment_method = $request->payment_method ?? 'all';
        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-t');

        $data['filters'] = [
            'category' => $category,
            'payment_method' => $payment_method,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];

        // Get income data
        $query = Income::with('category')
            ->whereBetween('date', [$start_date, $end_date]);

        if ($category != 'all') {
            $categoryModel = IncomeCategory::find($category);
            $data['filters']['category_name'] = $categoryModel ? $categoryModel->title : 'All';
            $query->where('category_id', $category);
        }

        if ($payment_method != 'all') {
            $paymentMethods = [
                1 => 'Card', 2 => 'Cash', 3 => 'Cheque', 
                4 => 'Bank Transfer', 5 => 'E-Wallet'
            ];
            $data['filters']['payment_method_name'] = $paymentMethods[$payment_method] ?? 'All';
            $query->where('payment_method', $payment_method);
        }

        $data['incomes'] = $query->orderBy('date', 'desc')->get();
        $data['total_income'] = $data['incomes']->sum('amount');

        // Summary by category
        $data['category_summary'] = $data['incomes']->groupBy('category_id')->map(function($group) {
            $category = $group->first()->category;
            return [
                'name' => $category ? $category->title : 'Unknown',
                'amount' => $group->sum('amount'),
                'count' => $group->count()
            ];
        });

        // Summary by payment method
        $data['payment_summary'] = $data['incomes']->groupBy('payment_method')->map(function($group) {
            $paymentMethods = [
                1 => 'Card', 2 => 'Cash', 3 => 'Cheque', 
                4 => 'Bank Transfer', 5 => 'E-Wallet'
            ];
            return [
                'name' => $paymentMethods[$group->first()->payment_method] ?? 'Unknown',
                'amount' => $group->sum('amount'),
                'count' => $group->count()
            ];
        });

        return $data;
    }
}