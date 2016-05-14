<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use URL;
use Mail;
use Session;
use PDF;
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
            $message = 'Report has been successfully created.';
        } else {
            $report->update($request->all());
            $message = 'Report with MRN #' . $report->id . ' has been successfully updated.';
        }
        
        Session::flash('message', $message);
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
        $pdf = PDF::loadView('emails.report', ['report' => $report, 'app' => config('mail.from.name')]);
        return $pdf->download('Report-MRN-' . $report->id . '-' . date('Y-m-d-H-i-s', strtotime($report->created_at)) . '.pdf');
    }
    
    public function toMail(Request $request, Report $report)
    {
        $mailData = ['report' => $report, 'app' => config('mail.from.name')];
        Mail::send('emails.report', $mailData, function($message) use ($report) {
            $message->from(config('mail.from.address'), config('mail.from.name'));
            $message->to($report->user->email, $report->user->name);
            $message->subject(config('mail.from.name') . ' Pass Code');
        });
        Session::flash('message', 'Report with MRN #' . $report->id . ' has been successfully sent to you.');
        return redirect(URL::previous());
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
       Session::flash('message', 'Report with MRN #' . $report->id . ' has been successfully removed.');
       return redirect('/reports');
   }
}
