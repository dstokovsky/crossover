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
        $this->middleware('auth');
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
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'procedure' => 'required|max:255',
            'statement' => 'required|max:255',
            'findings' => 'required|max:255',
            'impression' => 'required|max:255',
            'conclusion' => 'required',
        ]);
        
        $request->user()->reports()->create([
            'user_id' => $request->user_id,
            'procedure' => $request->procedure,
            'statement' => $request->statement,
            'findings' => $request->findings,
            'impression' => $request->impression,
            'conclusion' => $request->conclusion,
        ]);
        
        return redirect('/reports');
    }
    
    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Report  $report
     * @return Response
     */
   public function destroy(Request $request, Report $report)
   {
       $this->authorize('destroy', $report);
       $report->delete();
       return redirect('/reports');
   }
}
