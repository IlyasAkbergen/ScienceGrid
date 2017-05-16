<?php
namespace App\Http\Controllers;
use App\Investment;
use App\Project;
use App\Project_and_files;
use Auth;
use Illuminate\Http\Request;

class InvestmentsController extends Controller
{
    public function create(Request $request){
    	if( Auth::check() && Auth::user()->role === 'investor'){
			$inv = new Investment;
    		$inv->user_id = Auth::user()->id;
    		$inv->project_id = $request->project_id;
    		$inv->sum = $request->sum;
    		$inv->notes = $request->notes;
    		$inv->save();

    		return redirect()->route('show', ['id' => $request->project_id]);
    	}
    	else{
    		return view('auth.login');
    	}
    }
}
