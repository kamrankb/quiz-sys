<?php

namespace App\Http\Controllers;

use App\Models\BrandSettings;
use App\Models\CountryCurrencies;
use App\Models\Payments;
use App\Models\PaymentLink;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Traits\ReporthelperTrait;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Illuminate\Support\Str;


class DashboardController extends Controller
{
    use ReporthelperTrait;
    public $numberOfDays, $currentDay, $currentMonth, $currentYear;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {
        $teachers = User::role(['Teacher'])->get();
        $students = User::role(['Student'])->get();

        dd($teachers);
        return view('admin.index', compact('teachers', 'students'));
    }
}
