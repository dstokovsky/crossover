<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\ReportRepository;
use App\Report;

class ReportController extends Controller
{
    /**
     *
     * @var ReportRepository
     */
    protected $reports;

    public function __construct(ReportRepository $reports)
    {
        $this->reports = $reports;
    }
    
    /**
     * Display a list of all of the user's reports.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('reports.index', ['reports' => $this->reports->all($request->user())]);
    }
    
    /**
     * Create/update a report.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, Report $report)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'procedure' => 'required|max:255',
            'statement' => 'required|max:255',
            'findings' => 'required|max:255',
            'impression' => 'required|max:255',
            'conclusion' => 'required',
        ]);
        
        if (empty($report->id)) {
            Report::create($request->all());
        } else {
            $report->update($request->all());
        }
        
        return redirect('/reports');
    }
    
    public function view(Request $request, Report $report)
    {
        return view('reports.view', ['report' => $report]);
    }
    
    public function edit(Request $request, Report $report)
    {
        return view('reports.edit', ['report' => $report]);
    }
    
    public function toPdf(Request $request, Report $report)
    {
        return redirect('/reports');
    }
    
    public function toMail(Request $request, Report $report)
    {
        return redirect('/reports');
    }
    
    /**
     * Destroy the given report.
     *
     * @param  Request  $request
     * @param  Report  $report
     * @return Response
     */
   public function destroy(Request $request, Report $report)
   {
       $report->delete();
       return redirect('/reports');
   }
}
